<?php

use App\Repositories\Interfaces\builder_management\CounterInterface;

function table($data = [])
{
    $rows = [];

    $rows = table_design($rows);
    $rows = table_head($rows);
    $rows = table_body($rows);
    $rows = table_buttons($rows);
    $rows = table_filter($rows);
    return $rows;
}
function table_head($rows)
{
    $rows['head'] = [];
    $rows['head']['id'] = 'ID';
    $rows['head']['type'] = 'Type';
    $rows['head']['name'] = 'Name';
    $rows['head']['route_name'] = 'Url';
    $rows['head']['created_at'] = 'Created At';
    if ($rows['action']['edit'] == true || $rows['action']['delete'] == true || $rows['action']['view'] == true) {
        $rows['head']['action_buttons'] = 'Action';
    }

    return $rows;
}
function table_body($rows)
{
    $request = [];
    // $request['select'] = [];
    $request['created_at'] = '';
    $request['name'] = '';
    $request['page'] = '';
    $request['row_in_page'] = 20;

    $rows['body'] = dbApi();
    return $rows;
}
function table_buttons($rows)
{
    $rows['table'] = [];
    $rows['table']['multi_select'] = false;
    $rows['table']['add'] = true;
    $rows["table"]["add_link"] = route("api.create");
    $rows["table"]["delete_link"] = url("dashboard/builder/api/");
    $rows["table"]['edit_link']=url("dashboard/builder/api/");
    $rows["table"]['edit_link']=url("dashboard/builder/api/");
    $rows["table"]['view_link']=url("dashboard/builder/api/");
    $rows['table']['status_change']=false;
    $rows['table']['delete_all'] = false;
    $rows['table']['filter'] = false;
    return $rows;
}
function table_design($rows)
{
    $rows['action'] = [];
    $rows['action']['edit'] = false;
    $rows['action']['delete'] = false;
    $rows['action']['view'] = true;
    $rows['action']['pagination'] = true;
    $rows['action']['links'] = [];
    $rows['action']['edit_without'] = [];
    $rows['action']['delete_without'] = [];
    $rows['action']['view_without'] = [];
    $rows['action']['links_without'] = [];
    $rows["action"]["name"] = "API Controller";
    return $rows;
}
function table_filter($rows)
{
    $rows['filter']=[];
    // $rows['filter'] = [
    //     'created_at' => [
    //         'input_type' => 'input',
    //         'type' => 'date',
    //         'title' => '',
    //         'name' => 'created_at',
    //         'placeholder' => 'Created At',
    //         'class' => '',
    //         'around_div' => 'form-group form-md-line-input col-md-6',
    //         'below_div' => '',
    //         'value' => old('created_at'),
    //     ],
    // ];
    return $rows;
}
