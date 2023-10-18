<?php

namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\builder_management\CounterInterface;
use Illuminate\Http\Request;
use DB;
class ApiController extends Controller
{
    private $repository;
    public function __construct(CounterInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('builder_management/api');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & API';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('builder_management/api');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & API';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request)
    {
        $json=['prams_counters','form_body','form_header'];
        $type=[];
        foreach ($json as $json) {
            if (array_key_exists($json, $request->all())) {
                $array = json_encode($request[$json]);
                $first_row = current($request[$json]);
                if (is_array($first_row)) {
                    $key = array_key_first($request[$json]);
                    if ($request[$json][$key][0] != null) {
                        $array = json_encode($request[$json]);
                    } else {
                        $array = json_encode([]);
                    }
                }
                $type[$json] = $array;
            } else {
                $array = json_encode([]);
                $type[$json] = $array;
            }
        }
        $inserted=[
            'name'           =>$request->name,
            'route_name'     =>$request->route_name,
            'type'           =>$request->type,
            'note'           =>$request->note,
            'prams_counters' => $type['prams_counters'],
            'form_body'      =>$type['form_body'],
            'form_header'    => $type['prams_counters'],
        ];

        DB::table('install_api')->insert($inserted);
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function show($id)
    {
        $data= DB::table('install_api')->find($id);
        $data=(array)$data;
        $form = getForm('builder_management/api',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Api';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {

        $json=['prams_counters','form_body'];
        $type=[];
        foreach ($json as $json) {
            if (array_key_exists($json, $request->all())) {
                $array = json_encode($request[$json]);
                $first_row = current($request[$json]);
                if (is_array($first_row)) {
                    $key = array_key_first($request[$json]);
                    if ($request[$json][$key][0] != null) {
                        $array = json_encode($request[$json]);
                    } else {
                        $array = json_encode([]);
                    }
                }
                $type[$json] = $array;
            } else {
                $array = json_encode([]);
                $type[$json] = $array;
            }
        }
        $updated=[
            'name'=>$request->name,
            'route_name'=>$request->route_name,
            'type'=>$request->type,
            'note'=>$request->note,
            'prams_counters'=>$type['prams_counters'],
            'form_body'=>$type['form_body'],
        ];

        DB::table('install_api')->where('id', $request->id)->update($updated);
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }

    ///////////========================= Start Variables
    public function var_index(){
        // $data=$this->repository->data();

        $form=getForm('builder_management/var');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='API & Variable';
        $config['breadcrumb']=[];

        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    ///////////========================= End Variables

}
