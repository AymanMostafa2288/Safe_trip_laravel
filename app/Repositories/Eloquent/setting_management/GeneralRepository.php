<?php
namespace App\Repositories\Eloquent\setting_management;

use App\Repositories\Interfaces\setting_management\GeneralInterface;
use App\Repositories\Interfaces\database_management\SettingInterface;
use App\Models\General;
use File;
use DB;

class GeneralRepository implements GeneralInterface
{

    private $model;
    private $files=['app_logo','white_logo','app_favicon','about_us_image','vision_image'];

    public function __construct(General $model)
    {
        $this->model = $model;
    }

    public function store($request) {
        $data=[];
        $change_fields=[];
        $change_file=[];
        foreach($request as $key=>$value){
            if($key=='_token' || $key=='save' || $key=='id'){
                continue;
            }

            if(is_array($value)){
                if(array_key_exists(0,$value) && $value[0]==null){
                        unset($value[0]);
                }
                $value=json_encode($value);

            }elseif (File::isFile($value)) {
                $value=request()->file($key);
                $value=uploadImage($value);
                $old_file=$this->data($key);
                deleteFileStorage($old_file);
                $change_file[]=$key;
            }elseif(in_array($key,['app_mode'])){

                if($key=='app_mode'){
                    if($value=='maintenance' || $value=='development'){
                        if($value=='maintenance'){
                            app(SettingInterface::class)->set_env('APP_MODE','maintenance');
                        }else{
                            app(SettingInterface::class)->set_env('APP_MODE','website');
                        }
                        app(SettingInterface::class)->set_env('APP_ENV','local');
                        app(SettingInterface::class)->set_env('APP_DEBUG',"true");
                    }else{
                        app(SettingInterface::class)->set_env('APP_MODE','website');
                        app(SettingInterface::class)->set_env('APP_ENV','production');
                        app(SettingInterface::class)->set_env('APP_DEBUG',"false");
                    }
                }


            }
            $data[]=['name'=>$key,'value'=>$value];
            $change_fields[]=$key;

        }
        foreach($this->files as $file_name){

            if(!in_array($file_name,$change_file)){
                $old_file=$this->data($file_name);
                $data[]=['name'=>$file_name,'value'=>$old_file];
                $change_fields[]=$file_name;
            }
        }
        if(count($data) > 0){
            $this->model->whereIn('name',$change_fields)->delete();
            $this->model->insert($data);
        }
        return true;


    }

    public function data($field_name=''){

        if(env('APP_ENV')=='production'){
            if(!session()->has('genral_backend_session')){
                $data=$this->model->all();
                session(['genral_backend_session'=>$data]);
            }
            $sitting=session()->get('genral_backend_session');
        }else{
            $sitting=$this->model->all();

        }
        if($field_name!=''){

            $data=$sitting->where('name',$field_name)->first();

            if($data){
                return $data->value;
            }
            return '';
        }

        $data=$sitting;

        $data=$this->model->transformCollection($data,null,'name','value');
        return $data;

    }

}
