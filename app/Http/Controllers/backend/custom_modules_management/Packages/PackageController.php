<?php

namespace App\Http\Controllers\backend\custom_modules_management\Packages;

use App\Http\Controllers\Controller;
use App\Models\CustomModels\Route;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Packages\PackageInterface;
use App\Http\Requests\backend\custom_modules_management\Packages\StorePackageRequest;
use App\Http\Requests\backend\custom_modules_management\Packages\EditPackageRequest;
use  App\Jobs\ExportExcel;

class PackageController extends Controller
{
    private $repository;
    private $config;

    public function __construct(PackageInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();
        $title = 'Package';
        if(request()->route_id){
            $model_route = Route::find(request()->route_id);
            $key = 'name_'.getDashboardCurrantLanguage();
            $title = 'Route ('.$model_route->$key.')';
        }
        $config = setPageHead($route, $title, "Package", "package");
        $this->config = $config;
    }

    public function index()
    {
        $table = getTable("custom_modules_management/Packages/package");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("custom_modules_management/Packages/package");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StorePackageRequest $request)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return = $this->repository->save($request->validated());
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }

        $redirect = ($save_and_edit)  ? route("packages.show", $return->id).'?route_id='.$request->route_id : route("packages.index").'?route_id='.$request->route_id;
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("custom_modules_management/Packages/package", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditPackageRequest $request, $id)
    {
        $save_and_edit = (array_key_exists("save_and_edit", $request->all())) ? true : false;
        $return = $this->repository->save($request->validated(), $id);
        if ($return == false)
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");

        $redirect = ($save_and_edit)  ? route("packages.show", $return->id).'?route_id='.$request->route_id : route("packages.index").'?route_id='.$request->route_id;
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

    public function export_excel()
    {
        $filters = request()->all();
        $interfaces = app(Package::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }
}
