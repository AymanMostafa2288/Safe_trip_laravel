<?php
namespace App\Repositories\Eloquent\builder_management;

use App\Repositories\Interfaces\builder_management\ReportInterface;
use App\Models\Report;
use Exception;
use File;

class ReportRepository implements ReportInterface
{
    private $model;
    private $files=[];
    private $images = [];
    private $json = ['export_as','db_select','db_condtions','db_joins','report_order_by','report_addtinal_filter'];
    public function __construct(Report $model)
    {
        $this->model = $model;
    }
    public function data($request,$id='*',$for_role=false){
        if($id=='*'){
            if($for_role){
                $data=$this->model->whereNull('with_report')->get();
            }else{
                $data=$this->model->all();
            }

            $data=$this->model->transformCollection($data);
        }else{
            $data=$this->model->find($id);
            $data=$this->model->transformArray($data);
        }

        return $data;
    }
    public function store($request, $id = ""){
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
            return $data;
        } catch (Exception $e) {
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
            $data->show_in_left_side=$request['show_in_left_side'];
            $data->table_db=$request['table_db'];
            $data->fields_module=json_encode($request['fields_module']);
            $data->fields_action=json_encode($request['fields_action']);
            $data->crud_with=$request['crud_with'];
            $data->with_group=$request['with_group'];
            $data->save();
            return $data;
        }catch(Exception $e){
            return false;
        }
    }

    public function delete($id){
        try{
            $data=$this->model->find($id);
            $data->delete();
        }catch(Exception $e){
            return false;
        }

    }
    public function build_query(
        $main_table,
        $selects=[],
        $joins=[],
        $condtions=[],
        $groups_by=null,
        $orders=[],
        $limits=null,
        $get=[]
    ){
        $query='select ';
        if(count($selects) > 0){
            $result = array_merge_recursive(
                array_combine($selects['field_name'], $selects['show_as']),
                array_combine($selects['field_name'], $selects['type']),
                array_combine($selects['field_name'], $selects['field_value']),
                array_combine($selects['field_name'], $selects['default_value'])
            );

            $count_selects=count($result);
            $count=1;
            $select='';
            foreach($result as $key=>$value){
                if($value[1]=='normal'){
                    if($count_selects==$count){
                        $select.=$key.' as "'.$value[0].'"';
                    }else{
                        $select.=$key.' as "'.$value[0].'" ,';
                    }
                }elseif($value[1]=='select_query'){
                    if($count_selects==$count){
                        $select.='('.$key.') as "'.$value[0].'"';
                    }else{
                        $select.='('.$key.') as "'.$value[0].'" ,';
                    }
                }else{
                    if($count_selects==$count){
                        if(array_key_exists($value[2],$_GET)){
                            $key = str_replace('?', $_GET[$value[2]], $key);
                            $select.=$key.' as "'.$value[0].'"';
                        }else{
                            $select.=$value[3].' as "'.$value[0].'"';
                        }
                    }else{
                        if(array_key_exists($value[2],$_GET)){
                            $key = str_replace('?', $_GET[$value[2]], $key);
                            $select.=$key.' as "'.$value[0].'" ,';
                        }else{
                            $select.=$value[3].' as "'.$value[0].'" ,';
                        }
                    }

                }

                $count++;
            }
        }else{
            $select='*';
        }
        $query=$query.$select.' from '.$main_table;
        $join='';
        if(count($joins) > 0){
            $result = array_merge_recursive(
                array_combine($joins['table'], $joins['type']),
                array_combine($joins['table'], $joins['field1']),
                array_combine($joins['table'], $joins['field2'])
            );

            foreach($result as $key=>$value){

                $value[0] = str_replace('_', ' ',  $value[0]);
                $join.=' '.$value[0].' '.$key.' on '.$value[1].' = '.$value[2];
            }

        }
        $query=$query.$join;
        $condtions_query='';
        if(count($condtions) > 0){

            $result = array_merge_recursive(
                array_combine($condtions['param_name'], $condtions['field_name']),
                array_combine($condtions['param_name'], $condtions['condtion_type']),
                array_combine($condtions['param_name'], $condtions['operators']),
                array_combine($condtions['param_name'], $condtions['default']),
                array_combine($condtions['param_name'], $condtions['type'])
            );

            $count=0;

            foreach($result as $key=>$value){
                if($count!=0 && $condtions_query!=''){
                    if($value[4]=='dynamic'){
                        if(array_key_exists($key,$get)){
                            if($get[$key]){
                                $condtions_query.=' '.$value[2];
                            }
                        }
                    }else{
                        $condtions_query.=' '.$value[2];
                    }

                }
                if($value[4]=='dynamic'){
                    if(array_key_exists($key,$get)){
                        if($get[$key]){
                            $condtions_query.=' '.$value[0].' '.$value[1].' "'.$get[$key].'"';
                        }
                    }

                }else{

                    $condtions_query.=' '.$value[0].' '.$value[1].' '.$value[3];
                }

                $count++;
            }
        }

        if($condtions_query!=''){
            $query=$query.' where ' .$condtions_query;
        }

        if($groups_by){

            $query.=' GROUP BY '.$groups_by;
        }
        if($orders){
            if(array_key_exists('type',$orders) && !empty($orders['type'])){
                foreach($orders['type'] as $key=>$type){
                    $query.=' Order by '.$orders['field'][$key].' '.$type ;
                }
            }

        }
        if($limits){
            $query.=' Limit '.$limits;
        }

        return $query;
    }
    public function build_form($condtions=[],$addtional=[]){
        $result=[];
        $data=[];
        if(count($condtions) > 0){
            $data = array_merge_recursive(
                array_combine($condtions['param_name'], $condtions['field_type']),
                array_combine($condtions['param_name'], $condtions['from_table']),
                array_combine($condtions['param_name'], $condtions['table_field_name'])
            );
        }

        foreach($data as $key=>$row){
            if($row[0]){
                if($row[0]=='select'){

                    if($row[1]!=''){
                        $result["filter"][] =[
                            "input_type" => "select",
                            "type" => "select_search",
                            "title" => ucfirst(str_replace('_', ' ', $key)),
                            "name" => $key,
                            "placeholder" => ucfirst(str_replace('_', ' ', $key)),
                            "class" => "select2_category",
                            "around_div" => "form-group form-md-line-input col-md-6",
                            "options" => getValueByTableName($row[1], [$row[2]]),
                            "selected" => (array_key_exists($key,$_GET))?$_GET[$key]:'',
                        ];
                    }else{
                        $enum='App\Enum\Custom\\'.$row[2].'Enum';
                        $enum=$enum::options();
                        $result["filter"][] =[
                            "input_type" => "select",
                            "type" => "select_search",
                            "title" => ucfirst(str_replace('_', ' ', $key)),
                            "name" => $key,
                            "placeholder" => ucfirst(str_replace('_', ' ', $key)),
                            "class" => "select2_category",
                            "around_div" => "form-group form-md-line-input col-md-6",
                            "options" => $enum,
                            "selected" => (array_key_exists($key,$_GET))?$_GET[$key]:'',
                        ];
                    }

                }else{
                    $result["filter"][] = [
                        "input_type" => "input",
                        "type" => $row[0],
                        "title" => ucfirst(str_replace('_', ' ', $key)),
                        "name" => $key,
                        "placeholder" => ucfirst(str_replace('_', ' ', $key)),
                        "class" => "",
                        "around_div" => "form-group form-md-line-input col-md-6",
                        "value" =>(array_key_exists($key,$_GET))?$_GET[$key]:'',
                    ];
                }
            }


        }

        if(count($addtional) > 0){
            $data = array_merge_recursive(
                array_combine($addtional['field_name'], $addtional['field_type']),
                array_combine($addtional['field_name'], $addtional['from_table']),
                array_combine($addtional['field_name'], $addtional['table_field_name'])
            );
            foreach($data as $key=>$row){
                if($row[0]=='select'){
                    $result["filter"][] =[
                        "input_type" => "select",
                        "type" => "select_search",
                        "title" => ucfirst(str_replace('_', ' ', $key)),
                        "name" => $key,
                        "placeholder" => ucfirst(str_replace('_', ' ', $key)),
                        "class" => "select2_category",
                        "around_div" => "form-group form-md-line-input col-md-6",
                        "options" => getValueByTableName($row[1], [$row[2]]),
                        "selected" => (array_key_exists($key,$_GET))?$_GET[$key]:'',
                    ];
                }else{
                    $result["filter"][] = [
                        "input_type" => "input",
                        "type" => $row[0],
                        "title" => ucfirst(str_replace('_', ' ', $key)),
                        "name" => $key,
                        "placeholder" => ucfirst(str_replace('_', ' ', $key)),
                        "class" => "",
                        "around_div" => "form-group form-md-line-input col-md-6",
                        "value" =>(array_key_exists($key,$_GET))?$_GET[$key]:'',
                    ];
                }

            }
        }

        return $result;
    }

}
