<?php
namespace App\Repositories\Eloquent\builder_management;
use App\Repositories\Interfaces\builder_management\TeansfareInterface;
use App\Models\Chart;
use Exception;

class TeansfareRepository implements TeansfareInterface{
    private $model;
    private $files=[];

    public function __construct()
    {

    }

    public function data($request,$id='*',$field_name=''){
        if($id=='*'){
            // $data=$this->model;
            // $data=StatementDB($data,$request);
            // $data=$data->get();
            $data=[
                ['id'=>1,'name'=>'States'],
                ['id'=>2,'name'=>'Cities'],
                ['id'=>3,'name'=>'Areas'],
                ['id'=>4,'name'=>'Accounts'],
                ['id'=>5,'name'=>'Companies'],
                ['id'=>6,'name'=>'Delegates'],
                ['id'=>7,'name'=>'Categories'],
                ['id'=>8,'name'=>'Features'],
                ['id'=>9,'name'=>'Properties'],
                ['id'=>10,'name'=>'Projects'],
                ['id'=>11,'name'=>'Blogs'],
                ['id'=>12,'name'=>'Clicks'],
                ['id'=>13,'name'=>'Views'],
            ];
            // if(array_key_exists('select',$request)){
            //     $data=$this->model->transformCollection($data,'Custom',false,false,$request['select']);
            // }else{
            //     $data=$this->model->transformCollection($data);
            // }
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


}
?>
