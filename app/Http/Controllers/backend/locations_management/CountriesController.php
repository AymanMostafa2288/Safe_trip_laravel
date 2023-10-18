<?php
namespace App\Http\Controllers\backend\locations_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\locations_management\EditCountryRequest;
use App\Http\Requests\backend\locations_management\StoreCountryRequest;
use App\Jobs\ExportExcel;
use App\Repositories\Interfaces\locations_management\CountriesInterface;
use Illuminate\Http\Request;

class CountriesController extends Controller
{
    private $repository;
    private $config;
    public function __construct(CountriesInterface $repository)
    {
        $this->repository = $repository;
        $route=request()->route()->getName();
        $config=[];
        $config['main_title']='Locations';
        $config['sub_title']='Country';
        $config['breadcrumb']=[];
        $config['breadcrumb'][]=[
            'title'=>'Country',
            'route'=>'location.country.index',
            'query_builder'=>[],
            'params'=>'',
        ];
        $this->config=$config;

    }

    public function index()
    {
        $config=[];
        $config['main_title']='Locations';
        $config['sub_title']='Country';
        $config['breadcrumb']=[];
        $config['breadcrumb'][]=[
            'title'=>'Country',
            'route'=>request()->route()->getName(),
            'query_builder'=>[],
        ];

        $table = getTable("locations_management/country");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $config=[];
        $config['main_title']='Locations';
        $config['sub_title']='Country';
        $config['breadcrumb']=[];
        $config['breadcrumb'][]=[
            'title'=>'Country',
            'route'=>'location.country.index',
            'query_builder'=>[],
        ];
        $config['breadcrumb'][]=[
            'title'=>'Create Country',
            'route'=>request()->route()->getName(),
            'query_builder'=>[],
        ];
        $form = getForm("locations_management/country");
        return viewBackend("global", "create", ["form" => $form, "config" => $config]);
    }

    public function store(StoreCountryRequest $request)
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
            $redirect=route("location.country.show",$return->id);
        }else{
            $redirect=route("location.country.index");
        }
        return response()->json(['message'=>'Your Record Created Successfully','redirect'=>$redirect]);

    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("locations_management/country",$id,$data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditCountryRequest $request, $id)
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
            $redirect=route("location.country.show",$return->id);
        }else{
            $redirect=route("location.country.index");
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
        $config=setPageHead($route,"Locations","Counties","locations_management","(".$data['name'].")");
        $config["action"] = url("dashboard/modules/locations_management/translate/" . $id);
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
        $interfaces = app(Country::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }
}
