<?php

namespace App\Http\Controllers\backend\custom_modules_management\Schools;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Schools\SchoolInterface;
use App\Http\Requests\backend\custom_modules_management\Schools\StoreSchoolRequest;
use App\Http\Requests\backend\custom_modules_management\Schools\EditSchoolRequest;
use  App\Jobs\ExportExcel;

class SchoolController extends Controller
{
    private $repository;
    private $config;

    public function __construct(SchoolInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();
        $config = setPageHead($route, "Schools", "School", "school");
        $this->config = $config;
    }

    public function index()
    {
        $table = getTable("custom_modules_management/Schools/school");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("custom_modules_management/Schools/school");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreSchoolRequest $request)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return = $this->repository->save($request->validated());

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("schools.show", $return->id) : route("schools.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("custom_modules_management/Schools/school", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditSchoolRequest $request, $id)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all()))  ? true : false;
        $return = $this->repository->save($request->validated(), $id);

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("schools.show", $return->id) : route("schools.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function destroy($id)
    {
        $return = $this->repository->delete($id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }

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
