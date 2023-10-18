<?php
namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use Illuminate\Http\Request;


class ModuleController extends Controller
{
    private $repository;
    public function __construct(ModuleInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {


        $table = getTable('builder_management/modules');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Connections';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('builder_management/modules');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Modules';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request)
    {

        $this->repository->store($request->all());
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function show($id)
    {
        $data=$this->repository->data([],$id);

        $form = getForm('builder_management/modules',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Modules';
        $config['breadcrumb']=[];
        return viewBackend('global','edit',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->update($request->all(),$id);
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
    public function repository(){
        $data=$_GET;
        $this->repository->create_repository_structures($data['name'],$data['folder'],$data['model'],$data['route'],$data['controller'],$data['module_id']);
        return redirect()->back()->with('success', 'Your Repository Created Successfully');

    }
    public function repository_delete(){
        $data=$_GET;
        $this->repository->delete_repository_structures($data['name'],$data['folder'],$data['model'],$data['route'],$data['controller'],$data['module_id']);
        return redirect()->back()->with('success', 'Your Repository Deleted Successfully');
    }
}
