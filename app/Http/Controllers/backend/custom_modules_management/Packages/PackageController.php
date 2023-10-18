<?php
namespace App\Http\Controllers\backend\custom_modules_management\Packages;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Packages\PackageInterface;
use App\Http\Requests\backend\custom_modules_management\Packages\StorePackageRequest;
use App\Http\Requests\backend\custom_modules_management\Packages\EditPackageRequest;
use  App\Jobs\ExportExcel;
class PackageController extends Controller
{
private $repository;
private $config;
public function __construct(PackageInterface $repository)
{
$this->repository = $repository;
$route=request()->route()->getName();
$config=setPageHead($route,"Packages","Package","packages");
$this->config=$config;
}

public function index()
 {
$table=getTable("custom_modules_management/Packages/package");
return viewBackend("global","index",["table"=>$table,"config"=>$this->config]);
 }

public function create()
{
$form=getForm("custom_modules_management/Packages/package");
return viewBackend("global","create",["form"=>$form,"config"=>$this->config]);
 }

public function store(StorePackageRequest $request)
{$save_and_edit=false;
if(array_key_exists("save_and_edit",$request->all())){
$save_and_edit=true;
}
$return=$this->repository->save($request->all());
if($return==false){
return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
}
if($save_and_edit){
$redirect=route("packages.show",$return->id);
}else{
$redirect=route("packages.index");
}
return response()->json(["message"=>"Your Record Created Successfully","redirect"=>$redirect]);
}

public function show($id)
{
$data=$this->repository->data([],$id);
$form=getForm("custom_modules_management/Packages/package",$id,$data);
return viewBackend("global","edit",["form"=>$form,"config"=>$this->config]);
}

public function update(EditPackageRequest $request, $id)
{$save_and_edit=false;
if(array_key_exists("save_and_edit",$request->all())){
$save_and_edit=true;
}
$return=$this->repository->save($request->all(),$id);
if($return==false){
return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
}
if($save_and_edit){
$redirect=route("packages.show",$return->id);
}else{
$redirect=route("packages.index");
}
return response()->json(["message"=>"Your Record Created Successfully","redirect"=>$redirect]);
}

public function destroy($id)
{
$return=$this->repository->delete($id);
if($return==false){
return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
}

return redirect()->back()->with("success", "Your Record Deleted Successfully");
}


public function translate($id){
$data = $this->repository->data([], $id);
$route=request()->route()->getName();
$config = setPageHead($route, "Packages","Package","packages","(".$data["name"].")");
$config["action"] = url("dashboard/modules/packages/translate/" . $id);
$data = $this->repository->translate($id);
return viewBackend("global", "translate", ["config" => array_merge($config,$data)]);
}

public function translate_store(Request $request,$id){
$return=$this->repository->translate_store($request->all(),$id);
if($return==false){
return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
}
return redirect()->back()->with("success", "Your Record Created Successfully");
}

public function destroy_multi(Request $request){
 $return=$this->repository->delete_multi($request->ids);
if($return==false){
return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
}
return redirect()->back()->with("success", "Your Records Deleted Successfully");
}

public function export_excel(){
$filters=request()->all();
$interfaces=app(Package::class);
ExportExcel::dispatch($interfaces,$filters)->delay(now());
return redirect()->back()->with("success", "You will get the required excel file within an hour");
}
 }
