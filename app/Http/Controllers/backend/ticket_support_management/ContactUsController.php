<?php

namespace App\Http\Controllers\backend\ticket_support_management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\ticket_support_management\ContactUsInterface;
use App\Http\Requests\backend\ticket_support_management\StoreContactUsRequest;
use App\Http\Requests\backend\ticket_support_management\EditContactUsRequest;
use  App\Jobs\ExportExcel;

class ContactUsController extends Controller
{
    private $repository;
    private $config;
    public function __construct(ContactUsInterface $repository)
    {
        $this->repository = $repository;
        $route = request()->route()->getName();
        $config = setPageHead($route, "ContactUS", "ContactUs", "contact_u");
        $this->config = $config;
    }

    public function index()
    {
        changeBadgeStatus(1);
        $table = getTable("ticket_support_management/contactus");
        return viewBackend("global", "index", ["table" => $table, "config" => $this->config]);
    }

    public function create()
    {
        $form = getForm("ticket_support_management/contactus");
        return viewBackend("global", "create", ["form" => $form, "config" => $this->config]);
    }

    public function store(StoreContactUsRequest $request)
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
            $redirect = route("contact-us.show", $return->id);
        } else {
            $redirect = route("contact-us.index");
        }
        return response()->json(["message" => "Your Record Created Successfully", "redirect" => $redirect]);
    }

    public function show($id)
    {
        $data = $this->repository->data([], $id);
        $form = getForm("ticket_support_management/contactus", $id, $data);
        return viewBackend("global", "edit", ["form" => $form, "config" => $this->config]);
    }

    public function update(EditContactUsRequest $request, $id)
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
            $redirect = route("contact-us.show", $return->id);
        } else {
            $redirect = route("contact-us.index");
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
        $config = setPageHead($route, "ContactUS", "ContactUs", "contact-us", "(" . $data["name"] . ")");
        $config["action"] = url("dashboard/modules/contact-us/translate/" . $id);
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
        $interfaces = app(ContactUs::class);
        ExportExcel::dispatch($interfaces, $filters)->delay(now());
        return redirect()->back()->with("success", "You will get the required excel file within an hour");
    }
}
