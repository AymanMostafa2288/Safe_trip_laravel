<?php

namespace App\Http\Controllers\backend\custom_modules_management\Supervisors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Supervisors\SupervisorInterface;
use App\Http\Requests\backend\custom_modules_management\Supervisors\StoreSupervisorRequest;
use App\Http\Requests\backend\custom_modules_management\Supervisors\EditSupervisorRequest;
use  App\Jobs\ExportExcel;

class SupervisorController extends Controller
{
    private $repository;
    private $config;

    public function __construct(SupervisorInterface $repository)
    {
        $this->repository = $repository;
        $route            = request()->route()->getName();
        $config           = setPageHead($route, "Supervisors", "Supervisor", "supervisor");
        $this->config     = $config;
    }

    public function index()
    {
        $table = getTable("custom_modules_management/Supervisors/supervisor");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("custom_modules_management/Supervisors/supervisor");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreSupervisorRequest $request)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return = $this->repository->save($request->validated());

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ?  route("supervisors.show", $return->id) : route("supervisors.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("custom_modules_management/Supervisors/supervisor", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditSupervisorRequest $request, $id)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return = $this->repository->save($request->validated(), $id);

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("supervisors.show", $return->id) :route("supervisors.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function destroy($id)
    {
        $return = $this->repository->delete($id);

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");


        return redirect()->back()->with("success", "Your Record Deleted Successfully");
    }
    public function destroy_multi(Request $request)
    {
        $return = $this->repository->delete_multi($request->ids);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        return redirect()->back()->with("success", "Your Records Deleted Successfully");
    }
}
