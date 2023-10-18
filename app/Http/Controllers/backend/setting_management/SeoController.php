<?php

namespace App\Http\Controllers\backend\setting_management;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\setting_management\SeoInterface;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    private $repository;
    private $config;
    public function __construct(SeoInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();

        $config = setPageHead($route, "Settings", "Settings & Seo", "seo");
        $this->config=$config;

    }
    public function index()
    {

        $data=[];
        $table = getTable('setting_management/seo',$data);
        return viewBackend('global','index',['table'=>$table,'config'=>$this->config]);
    }
    public function create()
    {

        $form = getForm('setting_management/seo');
        return viewBackend('global','create',['form'=>$form,'config'=>$this->config]);
    }
    public function store(Request $request)
    {

        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all())) {
            $save_and_edit = true;
        }
        $return = $this->repository->save($request->all());
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        if ($save_and_edit) {
            return redirect()->route("seo.show", $return->id)->with("success", "Your Record Created Successfully");
        } else {
            return redirect()->route("seo.index")->with("success", "Your Record Created Successfully");
        }
    }
    public function show($id)
    {
        $data=$this->repository->data([],$id);

        $form = getForm('setting_management/seo','',$data);
        $this->config['breadcrumb'][1]['title']='Edit'.' '.$this->config['breadcrumb'][1]['title'];

        return viewBackend('global','edit',['form'=>$form,'config'=>$this->config]);
    }
    public function update(Request $request, $id)
    {
        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all())) {
            $save_and_edit = true;
        }
        $return = $this->repository->save($request->all(),$id);
        if ($save_and_edit) {
            return redirect()->route("seo.show", $return->id)->with("success", "Your Record Created Successfully");
        } else {
            return redirect()->route("seo.index")->with("success", "Your Record Created Successfully");
        }
    }
    public function destroy($id)
    {
        $this->repository->delete($id);
        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
}
