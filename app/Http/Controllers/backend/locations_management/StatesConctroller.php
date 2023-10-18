<?php
namespace App\Http\Controllers\backend\locations_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\locations_management\EditCityRequest;
use App\Http\Requests\backend\locations_management\StoreCityRequest;
use App\Jobs\ExportExcel;
use App\Repositories\Interfaces\locations_management\CitiesInterface;
use Illuminate\Http\Request;
use DB;

class StatesConctroller extends Controller
{
    private $repository;
    private $config;
    public function __construct(CitiesInterface $repository)
    {
        $this->repository = $repository;
        $route=request()->route()->getName();
        $config=[];
        $config['main_title']='Locations';
        $config['sub_title']='State';
        $config['breadcrumb']=[];
        $config['breadcrumb'][]=[
            'title'=>'State',
            'route'=>'location.state.index',
            'query_builder'=>[],
        ];
        $this->config=$config;
    }
    public function index()
    {

        $table = getTable("locations_management/state");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $this->config['breadcrumb'][]=[
            'title'=>'Create State',
            'route'=>'location.state.create',
            'query_builder'=>'',

        ];
        $form = getForm("locations_management/state");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreCityRequest $request)
    {
        $save_and_edit=false;
        if(array_key_exists("save_and_edit",$request->all())){
            $save_and_edit=true;
        }
        $return = $this->repository->save($request->all());
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        if($save_and_edit){
            $redirect=route("location.state.show",$return->id);
        }else{
            $redirect=route("location.state.index");
        }
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("locations_management/city",$id,$data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditCityRequest $request, $id)
    {
        $save_and_edit=false;
        if(array_key_exists("save_and_edit",$request->all())){
            $save_and_edit=true;
        }
        $return = $this->repository->save($request->all(), $id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        if($save_and_edit){
            $redirect=route("location.state.show",$return->id);
        }else{
            $redirect=route("location.state.index");
        }
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }

    public function destroy($id)
    {
        $return = $this->repository->delete($id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }

        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }

    public function translate($id)
    {
        $data = $this->repository->data([], $id);
        $route=request()->route()->getName();
        $config=setPageHead($route,"Locations","Cities","locations_city","(".$data['name'].")");
        $config["action"] = url("dashboard/modules/locations_city/translate/" . $id);
        $data = $this->repository->translate($id);
        return viewBackend("global", "translate", ["config" => array_merge($config,$data)]);
    }

    public function translate_store(Request $request, $id)
    {
        $return = $this->repository->translate_store($request->all(), $id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        return redirect()->back()->with("success", "Your Record Created Successfully");
    }

    public function destroy_multi(Request $request)
    {
        $return = $this->repository->delete_multi($request->ids);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        return redirect()->back()->with("success", "Your Records Deleted Successfully");
    }

    public function export_excel()
    {
        $filters = request()->all();
        $interfaces = app(City::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }



}
