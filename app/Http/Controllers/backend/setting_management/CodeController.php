<?php

namespace App\Http\Controllers\backend\setting_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\setting_management\CodeInterface;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    private $repository;
    public function __construct(CodeInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {

        $data=[];

        $table = getTable('setting_management/codes',$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Settings & Codes';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('setting_management/codes');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Settings & Codes';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request)
    {

        $this->repository->save($request->all());
        return redirect()->back()->with('success', 'Your Record Created Successfully');
    }
    public function show($id)
    {
        $data=$this->repository->data([],$id);

        $form = getForm('setting_management/codes','',$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Settings & Codes';
        $config['breadcrumb']=[];
        return viewBackend('global','edit',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->save($request->all(),$id);
        return redirect()->back()->with('success', 'Your Record Created Successfully');
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }

    public function EnumCreator($id){
        $this->repository->createEnum($id);
        return redirect()->back()->with("success", "Your Enum Created Successfully");
    }
}
