<?php
namespace App\Repositories\Eloquent\builder_management;

use App\Repositories\Interfaces\builder_management\CounterInterface;
use App\Models\Counter;
use Exception;

class CounterRepository implements CounterInterface
{

    private $model;
    private $files=[];

    public function __construct(Counter $model)
    {
        $this->model = $model;
    }
    public function data($request,$id='*',$field_name=''){

        if($id=='*'){
            $data=$this->model;

            $data=StatementDB($data,$request);
            $data=$data->get();
            if(array_key_exists('select',$request)){
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
    public function store($request){
        try{
            unset($request['_token']);
            if(array_key_exists('prams_counters',$request)){
                $request['prams_counters']=json_encode($request['prams_counters']);
            }
            $data=$this->model->create($request);
            return $data;
        }catch(Exception $e){
            dd($e);
            return false;
        }
    }
    public function update($request,$id){
        try{
            unset($request['_token']);
            $data=$this->model->find($id);
            $data->name=$request['name'];
            $data->is_active=$request['is_active'];
            $data->statement=$request['statement'];
            $data->module_related=$request['module_related'];
            $data->report_related=$request['report_related'];
            $data->prams_counters=json_encode($request['prams_counters']);
            $data->type=$request['type'];
            $data->icon=$request['icon'];
            $data->ordered=$request['ordered'];
            $data->save();
            return $data;
        }catch(Exception $e){
            dd($e);
            return false;
        }
    }

    public function delete($id){
        try{
            $data=$this->model->find($id);
            $data->delete();
            return $data;
        }catch(Exception $e){
            return false;
        }

    }
}
?>
