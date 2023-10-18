<?php

namespace App\Http\Controllers\backend\setting_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    private $repository;
    public function __construct(LanguageInterface $repository)
    {
        $this->repository = $repository;
    }
    public function index()
    {
        $table = getTable('setting_management/languages');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Settings & Languages';
        $config['breadcrumb']=[];
        return viewBackend('global','index',['table'=>$table,'config'=>$config]);
    }
    public function create()
    {
        $form = getForm('setting_management/languages');
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Settings & Languages';
        $config['breadcrumb']=[];
        return viewBackend('global','create',['form'=>$form,'config'=>$config]);
    }
    public function store(Request $request){
        $this->repository->save($request->all());
        return redirect()->back()->with('success', 'Your Record Created Successfully');
    }
    public function show($id){
        $data=$this->repository->data([],$id);
        $form = getForm('setting_management/languages',$id,$data);
        $config=[];
        $config['main_title']='Installation';
        $config['sub_title']='Settings & Languages';
        $config['breadcrumb']=[];
        return viewBackend('global','edit',['form'=>$form,'config'=>$config]);
    }
    public function update(Request $request, $id)
    {
        $this->repository->save($request->all(),$id);
        return redirect()->back()->with('success', 'Your Record Created Successfully');
    }
    public function destroy($id){

        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
}
