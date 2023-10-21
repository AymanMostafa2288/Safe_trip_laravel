<?php

namespace App\Http\Controllers\backend\custom_modules_management\Routes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Routes\RouteInterface;
use App\Http\Requests\backend\custom_modules_management\Routes\StoreRouteRequest;
use App\Http\Requests\backend\custom_modules_management\Routes\EditRouteRequest;
use  App\Jobs\ExportExcel;

class RouteController extends Controller
{
    private $repository;
    private $config;

    public function __construct(RouteInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();
        $config = setPageHead($route, "Routes", "Route", "route");
        $this->config = $config;
    }

    public function index()
    {
        $table = getTable("custom_modules_management/Routes/route");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("custom_modules_management/Routes/route");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreRouteRequest $request)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return        = $this->repository->save($request->all());

        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        $redirect = ($save_and_edit)? route("routes.show", $return->id):route("routes.index");
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);

        $form = getForm("custom_modules_management/Routes/route", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditRouteRequest $request, $id)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return        = $this->repository->save($request->all(), $id);

        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit) ? route("routes.show", $return->id) : route("routes.index");
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
