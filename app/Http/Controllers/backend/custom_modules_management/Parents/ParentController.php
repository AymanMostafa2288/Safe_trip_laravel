<?php

namespace App\Http\Controllers\backend\custom_modules_management\Parents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Parents\ParentsInterface;
use App\Http\Requests\backend\custom_modules_management\Parents\StoreParentRequest;
use App\Http\Requests\backend\custom_modules_management\Parents\EditParentRequest;
use  App\Jobs\ExportExcel;

class ParentController extends Controller{

    private $repository;
    private $config;

    public function __construct(ParentsInterface $repository){

        $this->repository = $repository;
        $route            = request()->route()->getName();
        $config           = setPageHead($route, "Parents", "Parent", "parent");
        $this->config     = $config;
    }

    public function index(){

        $table = getTable("custom_modules_management/Parents/parent");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create(){

        $form = getForm("custom_modules_management/Parents/parent");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreParentRequest $request){

        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all()))
            $save_and_edit = true;

        $return = $this->repository->save($request->validated());

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("parents.show", $return->id) : route("parents.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id){

        $data = $this->repository->data([], $id);
        $form = getForm("custom_modules_management/Parents/parent", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditParentRequest $request, $id){

        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all()))
            $save_and_edit = true;

        $return = $this->repository->save($request->validated(), $id);

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("parents.show", $return->id) : route("parents.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function destroy($id){
        $return = $this->repository->delete($id);

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }


    public function translate($id){

        $data             = $this->repository->data([], $id);
        $route            = request()->route()->getName();
        $config           = setPageHead($route, "Parents", "Parent", "parents", "(" . $data["name"] . ")");
        $config["action"] = url("dashboard/modules/parents/translate/" . $id);
        $data             = $this->repository->translate($id);
        return viewBackend("global", "translate", ["config" => array_merge($config, $data)]);
    }

    public function translate_store(Request $request, $id){

        $return = $this->repository->translate_store($request->all(), $id);
        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        return redirect()->back()->with("success", "Your Record Created Successfully");
    }

    public function destroy_multi(Request $request){

        $return = $this->repository->delete_multi($request->ids);
        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        return redirect()->back()->with("success", "Your Records Deleted Successfully");
    }

    public function export_excel(){

        $filters    = request()->all();
        $interfaces = app(Parent::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }
}
