<?php

namespace App\Repositories\Eloquent\builder_management;

use App\Repositories\Interfaces\builder_management\NotificationInterface;
use App\Models\Notification;
use Exception;
use DB;

class NotificationRepository implements NotificationInterface
{
    public $model;
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }
    public function data($request, $id = "*", $field_name = "")
    {
        $data = $this->model;
        $another_select = [];
        if ($id == "*") {
            if (array_key_exists("with", $request)) {
                foreach ($request["with"] as $val) {
                    $another_select[] = $val;
                }
            } else {
                $request["with"] = [];
            }
            $data = StatementDB($data, $request);
            $data = $data->get();
            if (array_key_exists("select", $request) && !empty($request["select"])) {
                $request["select"] = array_merge($request["select"], $another_select);
                $data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);
            } else {
                $data = $this->model->transformCollection($data);
            }
        } else {
            if (array_key_exists("with", $request)) {
                foreach ($request["with"] as $val) {
                    $another_select[] = $val;
                }

            } else {
                $request["with"] = [];
            }
            $data = StatementDB($data, $request);
            $data = $data->where("id", $id);
            $data = $data->first();
            $data = $this->model->transformArray($data);
            if ($field_name != "") {
                $data = $data[$field_name];
            }
        }
        return $data;
    }
    public function save($request, $id = "")
    {
        try {
            if ($id != "") {
                if ($id != $request["id"]) {
                    return false;
                } else {
                    unset($request["id"]);
                }
                unset($request["_method"]);
            }
            unset($request["_token"]);


            $data = $this->model->updateOrCreate(
                ["id" => $id],
                $request
            );
            return $data;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
    public function delete($id)
    {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                return false;
            }
            $data->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete_multi($ids)
    {
        try {
            $table_name = $this->model->table_name;

            $this->model->whereIn("id", $ids)->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
