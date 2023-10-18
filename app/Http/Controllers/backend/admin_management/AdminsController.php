<?php

namespace App\Http\Controllers\backend\admin_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\admin_management\AdminInterface;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    private $repository;
    public function __construct(AdminInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('admin_management/admins');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Administrator & Admins';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('admin_management/admins');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Administrator & Admins';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request)
    {
        $this->repository->save($request->all());
        $redirect=route("admins.index");
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }
    public function show($id)
    {
        $data=$this->repository->data([],$id);
        $form = getForm('admin_management/admins',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Administrator & Admins';
        $config['breadcrumb']=[];
        return viewBackend('global','edit',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->save($request->all(),$id);
        $redirect=route("admins.index");
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
}
