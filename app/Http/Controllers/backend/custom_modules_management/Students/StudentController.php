<?php

namespace App\Http\Controllers\backend\custom_modules_management\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Students\StudentInterface;
use App\Http\Requests\backend\custom_modules_management\Students\StoreStudentRequest;
use App\Http\Requests\backend\custom_modules_management\Students\EditStudentRequest;
use  App\Jobs\ExportExcel;

class StudentController extends Controller
{
    private $repository;
    private $config;

    public function __construct(StudentInterface $repository){

        $this->repository = $repository;
        $route            = request()->route()->getName();
        $config           = setPageHead($route, "Students", "Student", "student");
        $this->config     = $config;
    }

    public function index(){

        $table = getTable("custom_modules_management/Students/student");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create(){

        $form = getForm("custom_modules_management/Students/student");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreStudentRequest $request){

        $save_and_edit = false;

        if (array_key_exists("save_and_edit", $request->all()))
            $save_and_edit = true;

        $return = $this->repository->save($request->validated());
        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect =($save_and_edit) ?  route("students.show", $return->id): route("students.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id){

        $data = $this->repository->data([], $id);
        $form = getForm("custom_modules_management/Students/student", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditStudentRequest $request, $id){

        $save_and_edit = false;

        if (array_key_exists("save_and_edit", $request->all()))
            $save_and_edit = true;

        $return = $this->repository->save($request->validated(), $id);
        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("students.show", $return->id): route("students.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function destroy($id){

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
