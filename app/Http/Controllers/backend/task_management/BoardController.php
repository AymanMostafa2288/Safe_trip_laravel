<?php

namespace App\Http\Controllers\backend\task_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\task_management\BoardsInterface;
use App\Http\Requests\backend\task_management\StoreBoardsRequest;
use App\Http\Requests\backend\task_management\EditBoardsRequest;

class BoardController extends Controller
{
    private $repository;
    private $config;
    public function __construct(BoardsInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();
        $config = setPageHead($route, "Boards Management", "Boards", "board");
        $this->config = $config;
    }

    public function index()
    {
        $table = getTable("task_management/boards");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("task_management/boards");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreBoardsRequest $request)
    {
        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all())) {
            $save_and_edit = true;
        }
        $return = $this->repository->save($request->all());
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        if($save_and_edit){
            $redirect=route("boards.show",$return->id);
        }else{
            $redirect=route("boards.index");
        }
        return response()->json(['message'=>'Your Record Saved Successfully','redirect'=>$redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("task_management/boards", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditBoardsRequest $request, $id)
    {
        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all())) {
            $save_and_edit = true;
        }
        $return = $this->repository->save($request->all(), $id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        if($save_and_edit){
            $redirect=route("boards.show",$return->id);
        }else{
            $redirect=route("boards.index");
        }
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
