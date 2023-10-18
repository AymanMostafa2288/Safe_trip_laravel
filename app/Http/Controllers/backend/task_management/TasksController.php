<?php
namespace App\Http\Controllers\backend\task_management;

use App\Http\Controllers\Controller;
use App\Http\Requests\backend\task_management\EditTaskRequest;
use App\Http\Requests\backend\task_management\StoreTaskRequest;
use App\Jobs\ExportExcel;
use App\Repositories\Interfaces\task_management\TasksInterface;
use Illuminate\Http\Request;

class TasksController extends Controller
{
    private $repository;
    private $config;
    public function __construct(TasksInterface $repository)
    {
        $this->repository = $repository;
        $route=request()->route()->getName();
        $stages=getValueByTableName("install_boards", ["title"], ['id'=>$_GET['board_id']],[],false,true);
        $stage_title=$stages->title;
        $config=setPageHead($route,"Tasks ( ". $stage_title ." Board )","Tasks","task");
        $this->config=$config;
    }

    public function index()
    {
        // $table = getTable("custom_modules_management/accounts_management/task");
        // $config = [];
        // $config["main_title"] = "";
        // $config["sub_title"] = "";
        // $config["breadcrumb"] = [];


        $stages=getValueByTableName("install_boards", ["stages"], ['id'=>$_GET['board_id']],[],false,true);
        $stages_name=json_decode($stages->stages,true)['name'];
        $stages=json_decode($stages->stages,true)['title'];
        $stages=array_combine($stages_name,$stages);

        $request=[];
        $request['where']=[];
        $request['where'][]=['board_id'=>$_GET['board_id']];
        $tasks=$this->repository->data($request);
        return viewBackend("custom", "kanban", ["tasks" => $tasks,"stages" => $stages, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("task_management/task");
        $config = [];
        $config["main_title"] = "";
        $config["sub_title"] = "";
        $config["breadcrumb"] = [];
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreTaskRequest $request)
    {
        $return = $this->repository->save($request->all());
        $redirect=route("tasks.index");
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("task_management/task", $id,$data);
        $config = [];
        $config["main_title"] = "";
        $config["sub_title"] = "";
        $config["breadcrumb"] = [];
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditTaskRequest $request, $id)
    {
        $return = $this->repository->save($request->all(), $id);
        $redirect=route("tasks.index");
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
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
