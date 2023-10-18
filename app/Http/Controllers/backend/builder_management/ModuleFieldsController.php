<?php
namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\builder_management\ModuleFieldsInterface;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\setting_management\LanguageInterface;

class ModuleFieldsController extends Controller
{
    private $repository;
    public function __construct(ModuleFieldsInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {

        $data=[];
        $data['table_name']='Modules Fields Controller';
        $data['related_to']=$_GET['id'];

        $table = getTable('builder_management/modules_fields',$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Connections';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {

        $form = getForm('builder_management/modules_fields');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Modules';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request)
    {

        $this->repository->save($request->all());
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function show($id)
    {

        $data=$this->repository->data(request()->all(),$id);

        $form = getForm('builder_management/modules_fields',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Modules';
        $config['breadcrumb']=[];
        return viewBackend('global','edit',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->save($request->all(),$id);
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
}
