<?php

namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\builder_management\CounterInterface;
use Illuminate\Http\Request;

class CountersController extends Controller
{
    private $repository;
    public function __construct(CounterInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('builder_management/counters');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='DataBase & Counters';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('builder_management/counters');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Counters';
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
        $form = getForm('builder_management/counters',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Counters';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
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
}
