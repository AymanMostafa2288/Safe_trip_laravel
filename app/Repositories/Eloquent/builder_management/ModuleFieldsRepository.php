<?php
namespace App\Repositories\Eloquent\builder_management;

use App\Repositories\Interfaces\builder_management\ModuleFieldsInterface;
use App\Models\ModuleField;
use Exception;
use File;

class ModuleFieldsRepository implements ModuleFieldsInterface
{
    private $model;
    private $images=[];
    private $json=['fields_action','fields_module'];

    public function __construct(ModuleField $model)
    {
        $this->model = $model;
    }
    public function data($request,$id='*',$field_name=''){
        if($id=='*'){
            $data=$this->model;

            $data=StatementDB($data,$request);
            $data=$data->get();

            if(array_key_exists('select',$request) && !empty($request['select'])){
                $data=$this->model->transformCollection($data,'Custom',false,false,$request['select']);
            }else{
                $data=$this->model->transformCollection($data);
            }

        }else{
            $data=$this->model;
            $data=StatementDB($data,$request);
            $data=$data->where('id',$id);
            $data=$data->first();

            $data=$this->model->transformArray($data);
            if($field_name!=''){
                $data=$data[$field_name];
            }
        }
        return $data;
    }
    public function save($request,$id=''){
        try{

            if($id!=''){
                if($id!=$request['id']){
                    return false;
                }else{
                    unset($request['id']);
                }
                unset($request['_method']);
            }
            unset($request['_token']);
            foreach($this->json as $json){
                if(array_key_exists($json,$request)){
                    $array=json_encode($request[$json]);

                    $first_row=current($request[$json]);
                    if(is_array($first_row)){
                        $key=array_key_first($request[$json]);
                        if($request[$json][$key][0]!=null){
                            $array=json_encode($request[$json]);
                        }else{
                            $array=json_encode([]);
                        }
                    }
                    $request[$json]=$array;
                }else{
                    $array=json_encode([]);
                    $request[$json]=$array;
                }
            }

            foreach($this->images as $image_name){
                if(array_key_exists($image_name,$request) && File::isFile($request->$image_name)){
                    $image=request()->file($image_name);
                    $image=uploadImage($image);
                    $request[$image_name]=$image;
                    if($id!=''){
                        $old_image=$this->data([],$id,$image_name);
                        deleteFileStorage($old_image);
                    }

                }else{
                    if($id!=''){
                        $old_image=$this->data([],$id,$image_name);
                        $request[$image_name]=$old_image;
                    }else{
                        $request[$image_name]='';
                    }
                }
            }
            $data=$this->model->updateOrCreate(
                ['id'=>$id],
                $request
            );
            return $data;
        }catch(Exception $e){
            dd($e);
            return false;
        }
    }
    public function delete($id){
        try{
            $data=$this->model->find($id);
            if(!$data){
                return false;
            }
            $data->delete();
        }catch(Exception $e){
            return false;
        }
    }

}
