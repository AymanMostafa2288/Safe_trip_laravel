<?php

namespace App\Repositories\Eloquent\custom_modules_management\Subscriptions;

use App\Repositories\Interfaces\custom_modules_management\Subscriptions\SubscriptionInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Models\CustomModels\Subscription;
use Exception;
use File;
use DB;
use App\Events\CreateSlugEvent;
use App\Events\CreateTranslationEvent;
use App\Events\SetRelationEvent;
use App\Events\SetCodeEvent;

class SubscriptionRepository implements SubscriptionInterface
{
    public $model;
    private $files = [];
    private $images = [];
    private $json = [];

    public function __construct(Subscription $model)
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
            foreach ($this->json as $json) {
                if (array_key_exists($json, $request)) {
                    $array = json_encode($request[$json]);
                    $first_row = current($request[$json]);
                    if (is_array($first_row)) {
                        $key = array_key_first($request[$json]);
                        if ($request[$json][$key][0] != null) {
                            $array = json_encode($request[$json]);
                        } else {
                            $array = json_encode([]);
                        }
                    }
                    $request[$json] = $array;
                } else {
                    $array = json_encode([]);
                    $request[$json] = $array;
                }
            }
            foreach ($this->images as $image_name) {
                $image = null;
                if(request()->hasFile($image_name)){
                    $image                = request()->file($image_name);
                    $image                = uploadImage($image);
                }
                $old_image            = '';
                if ($id != "")
                    $old_image = $this->data([], $id, $image_name);

                $request[$image_name] = handel_request_and_upload_file ($request,$image,$image_name,$id,$old_image);

            }
            foreach ($this->files as $file_name) {
                $file                = request()->file($file_name);
                $file                = uploadFile($file);
                $old_file            = '';
                if ($id != "")
                    $old_file = $this->data([], $id, $file_name);

                $request[$file_name] = handel_request_and_upload_file ($request,$file,$file_name,$id,$old_file);

            }
            $data = $this->model->updateOrCreate(["id" => $id], $request);
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
            foreach ($this->images as $image_name) {
                $old_image = $this->data([], $id, $image_name);
                deleteFileStorage($old_image);
            }
            foreach ($this->files as $file_name) {
                $old_file = $this->data([], $id, $file_name);
                deleteFileStorage($old_file);
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
            foreach ($ids as $id) {
                foreach ($this->images as $image_name) {
                    $old_image = $this->data([], $id, $image_name);
                    deleteFileStorage($old_image);
                }
                foreach ($this->files as $file_name) {
                    $old_file = $this->data([], $id, $file_name);
                    deleteFileStorage($old_file);
                }
            }
            $this->model->whereIn("id", $ids)->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}
