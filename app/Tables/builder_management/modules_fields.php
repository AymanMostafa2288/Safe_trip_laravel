<?php

use App\Repositories\Interfaces\builder_management\ModuleFieldsInterface;

function table($data = [])
{
    $rows = [];
    $related_to=false;
    if(array_key_exists('related_to',$data)){
        $related_to=$data['related_to'];
    }

    $rows = table_design($rows,$data);
    $rows = table_head($rows);
    $rows = table_body($rows,$related_to);
    $rows = table_buttons($rows,$related_to);
    $rows = table_filter($rows);
    return $rows;
}
function table_head($rows)
{
    $rows['head'] = [];
    $rows['head']['id'] = 'ID';
    $rows['head']['name'] = 'Name';
    $rows['head']['is_active'] = 'Is Active';
    $rows['head']['created_at'] = 'Created At';
    if ($rows['action']['edit'] == true || $rows['action']['delete'] == true || $rows['action']['view'] == true) {
        $rows['head']['action_buttons'] = 'Action';
    }
    return $rows;
}
function table_body($rows,$related_to=false)
{
    $request = [];
    $request['select'] = [];
    $request['created_at'] = '';
    $request['name'] = '';
    $request['page'] = '';
    $request['row_in_page'] = 100;
    $request['where']=[];
    if($related_to!==false) {
        $request['where'][] = ['module_id'=>$related_to];
    }
    $body = app(ModuleFieldsInterface::class)->data($request);
    // $body =[];
    $body=(array) json_decode(json_encode($body), true);

    $rows['body'] = $body;
    return $rows;
}
function table_buttons($rows,$related_to=false)
{
    $rows['table'] = [];
    $rows['table']['multi_select'] = false;
    $rows['table']['add'] = true;
    $rows["table"]["add_link"] = route("module_fields.create");
    if($related_to!=false){
        $rows["table"]["add_link"] = route("module_fields.create").'?related_to='.$related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/builder/module_fields/");
    $rows["table"]['edit_link']=url("dashboard/builder/module_fields/");
    $rows['table']['status_change']=true;
    $rows['table']['delete_all'] = false;
    $rows['table']['filter'] = false;
    return $rows;
}
function table_design($rows,$data)
{
    $rows['action'] = [];
    $rows['action']['edit'] = true;
    $rows['action']['delete'] = true;
    $rows['action']['view'] = false;
    $rows['action']['pagination'] = false;
    $rows['action']['links'] = [];
    $rows['action']['edit_without'] = [];
    $rows['action']['delete_without'] = [];
    $rows['action']['view_without'] = [];
    $rows['action']['links_without'] = [];
    $rows["action"]["name"] = $data['table_name'];
    return $rows;
}
function table_filter($rows)
{
    $rows['filter'] = [
        'created_at' => [
            'input_type' => 'input',
            'type' => 'date',
            'title' => '',
            'name' => 'created_at',
            'placeholder' => 'Created At',
            'class' => '',
            'around_div' => 'form-group form-md-line-input col-md-6',
            'below_div' => '',
            'value' => old('created_at'),
        ],
    ];
    return $rows;
}
