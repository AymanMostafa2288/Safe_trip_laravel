<?php

namespace App\Http\Controllers\backend\builder_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\builder_management\ChartInterface;
class ChartsController extends Controller
{
    private $repository;
    public function __construct(ChartInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('builder_management/charts');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Charts';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('builder_management/charts');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Charts';
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
        $form = getForm('builder_management/charts',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Builders & Charts';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->store($request->all(),$id);
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>'#']);
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
}
