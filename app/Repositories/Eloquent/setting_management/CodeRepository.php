<?php
namespace App\Repositories\Eloquent\setting_management;

use App\Models\Code;
use App\Repositories\Interfaces\setting_management\CodeInterface;
use Illuminate\Support\Facades\File;

class CodeRepository implements CodeInterface
{
    public $model;
    private $files = [];
    private $images = [];
    private $json = ['enum_body'];
    public function __construct(Code $model)
    {
        $this->model = $model;
    }
    public function data($request, $id = "*", $field_name = "")
    {
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
            $enum_file_name=$data->name.'Enum';
            if (!$data) {
                return false;
            }
            $path = base_path() . '/app/Enum/Custom/'.$enum_file_name.'.php';
            if (File::exists($path)) {
                unlink($path);
            }
            $data->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    public function createEnum($id){
        $enum=$this->model->find($id);
        $enum_file_name=$enum->name.'Enum';
        $path = base_path() . '/app/Enum/Custom/'.$enum_file_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        $enum_body=json_decode($enum->enum_body,true);
        $enum_body=array_combine($enum_body['name'],$enum_body['value']);
        $content=$this->enumContent($enum_file_name,$enum_body);
        File::put($path, $content);
        return true;
    }

    private function enumContent($name,$values){
        $code='';
        $code.='<?php';
        $code .="\n";
        $code.='namespace App\Enum\Custom;';
        $code .="\n";
        $code.='use App\Enum\BaseEnum;';
        $code .="\n";
        $code.='class '.$name.' extends BaseEnum{';
        $code .="\n";
        foreach ($values as $key => $value) {
            $code.='public const '.$key.' = "'.$value.'";';
            $code .="\n";
        }
        $code .="\n";
        $code.='}';
        return $code;

    }



}
