<?php
namespace App\Http\Controllers\backend\locations_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\locations_management\EditDistrictRequest;
use App\Http\Requests\backend\locations_management\StoreDistrictRequest;
use App\Jobs\ExportExcel;
use App\Repositories\Interfaces\locations_management\DistrictsInterface;
use Illuminate\Http\Request;
use DB;

class DistrictsController extends Controller
{
    private $repository;
    private $config;
    public function __construct(DistrictsInterface $repository)
    {
        $this->repository = $repository;
        $route=request()->route()->getName();
        $config=[];
        $config['main_title']='Locations';
        $config['sub_title']='District';
        $config['breadcrumb']=[];
        $config['breadcrumb'][]=[
            'title'=>'Districts',
            'route'=>'location.district.index',
            'query_builder'=>[],
        ];
        $this->config=$config;

    }

    public function index()
    {
        $table = getTable("locations_management/district");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("locations_management/district");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreDistrictRequest $request)
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
            $redirect=route("location.district.show",$return->id);
        }else{
            $redirect=route("location.district.index");
        }
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("locations_management/district", $id,$data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditDistrictRequest $request, $id)
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
            $redirect=route("location.district.show",$return->id);
        }else{
            $redirect=route("location.district.index");
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
        $config=setPageHead($route,"Locations","Areas","locations_area","(".$data['name'].")");
        $config["action"] = url("dashboard/modules/locations_areas/translate/" . $id);
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
        $interfaces = app(Area::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }


}
