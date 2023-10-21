<?php

namespace App\Http\Controllers\backend\custom_modules_management\Subscriptions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\custom_modules_management\Subscriptions\SubscriptionInterface;
use App\Http\Requests\backend\custom_modules_management\Subscriptions\StoreSubscriptionRequest;
use App\Http\Requests\backend\custom_modules_management\Subscriptions\EditSubscriptionRequest;
use  App\Jobs\ExportExcel;

class SubscriptionController extends Controller
{
    private $repository;
    private $config;

    public function __construct(SubscriptionInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();
        $config = setPageHead($route, "Subscriptions", "Subscription", "subscription");
        $this->config = $config;
    }

    public function index()
    {
        $table = getTable("custom_modules_management/Subscriptions/subscription");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("custom_modules_management/Subscriptions/subscription");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreSubscriptionRequest $request)
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
            $redirect = route("subscriptions.show", $return->id);
        } else {
            $redirect = route("subscriptions.index");
        }
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("custom_modules_management/Subscriptions/subscription", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditSubscriptionRequest $request, $id)
    {
        $save_and_edit = false;
        if (array_key_exists("save_and_edit", $request->all())) {
            $save_and_edit = true;
        }
        $return = $this->repository->save($request->all(), $id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        if ($save_and_edit) {
            $redirect = route("subscriptions.show", $return->id);
        } else {
            $redirect = route("subscriptions.index");
        }
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


    public function translate($id)
    {
        $data = $this->repository->data([], $id);
        $route = request()->route()->getName();
        $config = setPageHead($route, "Subscriptions", "Subscription", "subscriptions", "(" . $data["name"] . ")");
        $config["action"] = url("dashboard/modules/subscriptions/translate/" . $id);
        $data = $this->repository->translate($id);
        return viewBackend("global", "translate", ["config" => array_merge($config, $data)]);
    }

    public function translate_store(Request $request, $id)
    {
        $return = $this->repository->translate_store($request->all(), $id);
        if ($return == false) {
            return redirect()->back()->with("error", "Error In Code Please Return To IT Team");
        }
        return redirect()->back()->with("success", "Your Record Created Successfully");
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
        $interfaces = app(Subscription::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }
}
