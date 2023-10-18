<?php
namespace App\Repositories\Eloquent\builder_management;


use App\Models\Chart;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\builder_management\ChartInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use DB;
use Exception;
use File;
use Illuminate\Support\Facades\Hash;

class ChartRepository implements ChartInterface
{
    public $model;
    private $files = [];
    private $images = [];
    private $json = ['datasate_config','sql_statments'];
    public function __construct(Chart $model)
    {
        $this->model = $model;
    }
    public function data($request, $id = "*", $field_name = "")
    {

        if ($id == "*") {
            $data = $this->model;
            if(!array_key_exists('with', $request)){
                $request["with"] = [];
            }
            if(!array_key_exists('orderBy', $request)){
                $request["orderBy"]=['created_at'=>'DESC'];
            }

            $data = StatementDB($data, $request);
            $data = $data->get();
            if (array_key_exists("select", $request) && !empty($request["select"])) {
                $data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);
            } else {
                $data = $this->model->transformCollection($data);
            }
        } else {
            $data = $this->model;
            $request["with"] = [];
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
    public function store($request, $id = "")
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
                if (array_key_exists($image_name, $request) && File::isFile($request[$image_name])) {
                    $image = request()->file($image_name);
                    $image = uploadImage($image);
                    $request[$image_name] = $image;
                    if ($id != "") {
                        $old_image = $this->data([], $id, $image_name);
                        deleteFileStorage($old_image);
                    }
                } else {
                    if ($id != "") {
                        $old_image = $this->data([], $id, $image_name);
                        $request[$image_name] = $old_image;
                    } else {
                        $request[$image_name] = "default/user_account.png";
                    }
                }
            }
            foreach ($this->files as $file_name) {
                if (array_key_exists($file_name, $request) && File::isFile($request[$file_name])) {
                    $file = request()->file($file_name);
                    $file = uploadFile($file);
                    $request[$file_name] = $file;
                    if ($id != "") {
                        $old_file = $this->data([], $id, $file_name);
                        deleteFileStorage($old_file);
                    }
                } else {
                    if ($id != "") {
                        $old_file = $this->data([], $id, $file_name);
                        $request[$file_name] = $old_file;
                    } else {
                        $request[$file_name] = "";
                    }
                }
            }

            $old_data=[];
            $action='store';
            if($id != ""){
                $old_data=$this->data([], $id);
                $action='update';
            }

            $data = $this->model->updateOrCreate(
                ["id" => $id],
                $request
            );

            if ($id == "") {
                $request["id"] = $data->id;

            }

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

}
