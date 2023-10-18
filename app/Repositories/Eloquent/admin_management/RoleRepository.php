<?php
namespace App\Repositories\Eloquent\admin_management;
use App\Models\Role;
use App\Repositories\Interfaces\admin_management\RoleInterface;
use DB;
class RoleRepository implements RoleInterface {
    private $model;
    private $files = [];
    private $images = [];
    private $json = [
        'spasfice_permissions','reports_permissions','notifications_permissions'
    ];
    public function __construct(Role $model)
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
            $this->set_permissions($request['permissions'],$data->id);
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
            storeLogs($this->model->getTable(),$id,'delete',$data);
            $data->delete();
        } catch (Exception $e) {
            return false;
        }
    }
    private function set_permissions($permissions,$id){
        $rows=[];
        foreach ($permissions as $module=>$permission_array){
            foreach ($permission_array as $value){
                $rows[]=['role_id'=>$id,'module_id'=>$module,'permission_id'=>$value];
            }
        }
        DB::table('install_permission_moduel_roles')->where('role_id',$id)->delete();
        DB::table('install_permission_moduel_roles')->insert($rows);
        return true;
    }
}
?>
