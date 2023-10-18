<?php
namespace App\Repositories\Eloquent\locations_management;

use App\Events\CreateSlugEvent;
use App\Events\CreateTranslationEvent;
use App\Events\SetCodeEvent;
use App\Events\SetRelationEvent;
use App\Models\State;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\locations_management\StatesInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use DB;
use Exception;
use File;

class StatesRepository implements StatesInterface
{
    public $model;
    private $files = [];
    private $images = [];
    private $json = [];
    public function __construct(State $model)
    {
        $this->model = $model;
    }
    public function data($request, $id = "*", $field_name = ""){
        if ($id == "*") {
            $data = $this->model;
            $data = StatementDB($data, $request);
            $data = $data->get();
            if (array_key_exists("select", $request) && !empty($request["select"])) {
                $data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);
            } else {
                $data = $this->model->transformCollection($data);
            }
        } else {
            $data = $this->model;
            $request["with"] = ["slugable", "codes"];
            $data = StatementDB($data, $request);
            $data = $data->where("id", $id);
            $data = $data->first();

            if($data){
                $data = $this->model->transformArray($data);
                if ($field_name != "") {
                    $data = $data[$field_name];
                }
            }
        }
        return $data;
    }
    public function save($request, $id = ""){
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
                        $request[$image_name] = "";
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
            storeLogs($this->model->getTable(),$data->id,$action,$old_data,$data->toArray());
            if ($id == "") {
                $request["id"] = $data->id;
                event(new CreateTranslationEvent($request, $this->model->getTable()));
                unset($request["id"]);
                event(new SetRelationEvent($request, $this->model->getTable(), $data->id));
            }

            if (array_key_exists("codes", $request)) {
                event(new SetCodeEvent($request["codes"], $this->model->getTable(), $data->id));
            }
            return $data;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
    public function delete($id){
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
            storeLogs($this->model->getTable(),$id,'delete',$data);
            $data->delete();
            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public function translate($id){
        $data = $this->data(request()->all(), $id);
        $config = [];
        $request = [];
        $request["whereNotEqual"][] = ["is_main" => 0];
        $request["select"] = ["id", "name", "slug"];
        $config["langs"] = app(LanguageInterface::class)->data($request);
        $request = [];
        $request["whereNotEqual"][] = ["is_main" => 0];
        $fields = app(ModuleInterface::class)->data([], 9);
        $fields = $fields["fields"];
        $fields_translate = [];
        $form = "";
        foreach ($fields as $field) {
            if (in_array(6, json_decode($field->fields_action, true))) {
                $fields_translate[] = $field;
            }
        }
        $config["fields"] = $fields_translate;
        $config["data"] = $data["translate"];
        return $config;
    }

    public function translate_store($request, $id){
        try {
            unset($request["_token"]);
            $table_name = $this->model->getTable();
            $field_name = explode("_", $table_name);
            unset($field_name[0]);
            $field_name = implode("_", $field_name) . "_id";
            $table_name = $table_name . "_translate";
            $insert = [];
            foreach ($request as $lang => $value) {
                $value["lang"] = $lang;
                $value[$field_name] = $id;
                $insert[] = $value;
            }
            $old_data=DB::table($table_name)->where($field_name, $id)->get()->toArray();
            storeLogs($table_name,$id,'translate',$old_data,$insert);
            DB::table($table_name)->where($field_name, $id)->delete();
            DB::table($table_name)->insert($insert);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete_multi($ids) {
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
