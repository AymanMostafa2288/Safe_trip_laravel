<?php
namespace App\Repositories\Eloquent\task_management;

use App\Models\Task;
use App\Repositories\Interfaces\task_management\TasksInterface;
use Exception;
use File;
use Illuminate\Support\Facades\DB;

class TasksRepository implements TasksInterface
{
    public $model;
    private $files = [];
    private $images = ['images'];
    private $json = [];
    public function __construct(Task $model)
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

                if (array_key_exists($image_name, $request)) {
                    $image = request()->file($image_name);
                    $image = uploadImage($image);
                    $request[$image_name] = $image;
                    if ($id != "") {
                        $old_image = $this->data([], $id, $image_name);
                        if(array_key_exists($image_name."_removed",$request)){
                            $old_image=json_decode($old_image,true);
                            $removed_images=$request[$image_name."_removed"];
                            if($removed_images){
                                $removed_images=explode(',',$removed_images);
                                foreach($removed_images as $val){
                                    if(in_array($val,$old_image)){
                                        deleteFileStorage($val);
                                        $key = array_search($val, $old_image);
                                        unset($old_image[$key]);
                                    }
                                }
                            }
                            $new_image=json_decode($request[$image_name],true);
                            if($old_image==null){
                                $old_image=[];
                            }
                            $all_images=array_merge($old_image,$new_image);

                            $request[$image_name]=json_encode($all_images);
                        }else{
                            deleteFileStorage($old_image);
                        }
                    }
                } else {
                    if ($id != "") {
                        $old_image = $this->data([], $id, $image_name);
                        if(array_key_exists($image_name."_removed",$request)){
                            $removed_images=$request[$image_name."_removed"];
                            $old_image=json_decode($old_image,true);
                            if($removed_images){
                                $removed_images=explode(',',$removed_images);
                                foreach($removed_images as $val){
                                    if(in_array($val,$old_image)){
                                        deleteFileStorage($val);
                                        $key = array_search($val, $old_image);
                                        unset($old_image[$key]);
                                    }
                                }
                            }
                            $old_image=json_encode($old_image);
                        }
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

            if(array_key_exists('comments',$request)){
                $comments=[];
                $mention_to=[];
                foreach($request['comments']['comment'] as $key=>$value){
                    if($value){
                        if($value!=auth()->guard('admin')->id()){
                            $row=[];
                            $row['admin_id']=auth()->guard('admin')->id();
                            $row['task_id']=$data->id;
                            $row['comment']=$value;
                            $row['mention_to']=$request['comments']['mention_to'][$key];
                            $comments[]=$row;
                        }
                        if($request['comments']['mention_to'][$key]){
                            $mention_to[]=$request['comments']['mention_to'][$key];
                        }
                    }
                }
                // DB::table('install_tasks_comments')->where('task_id',$data->id)->delete();
                DB::table('install_tasks_comments')->insert($comments);

            }
            storeLogs($this->model->getTable(),$data->id,$action,$old_data,$data->toArray());
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
            storeLogs($this->model->getTable(),$id,'delete',$data);
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
