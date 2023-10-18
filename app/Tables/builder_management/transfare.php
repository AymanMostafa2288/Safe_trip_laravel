<?php

use App\Repositories\Interfaces\builder_management\TeansfareInterface;

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
    $rows['head']['name'] = 'Name';
    $rows['head']['action_buttons'] = 'Action';

    // if ($rows['action']['edit'] == true || $rows['action']['delete'] == true || $rows['action']['view'] == true) {
    //     $rows['head']['action_buttons'] = 'Action';
    // }
    return $rows;
}
function table_body($rows)
{
    $request = [];
    // $request['select'] = [];
    $request['created_at'] = '';
    $request['name'] = '';
    $request['page'] = '';
    $request['row_in_page'] = 700;

    $body = app(TeansfareInterface::class)->data($request);

    $body=(array) json_decode(json_encode($body), true);

    $rows['body'] = $body;
    return $rows;
}
function table_buttons($rows)
{
    $rows['table'] = [];
    $rows['table']['multi_select'] = false;
    $rows['table']['add'] = false;
    $rows["table"]["add_link"] = route("charts.create");
    $rows["table"]["delete_link"] = url("dashboard/builder/charts/");
    $rows["table"]['edit_link']=url("dashboard/builder/charts/");
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
    $rows['action']['view'] = false;
    $rows['action']['pagination'] = false;
    $rows['action']['links'] = [
        ['href'=>url("dashboard/builder/tranfare/data_transfare/"),'name'=>'Data Transfare','param'=>['id']],
    ];
    $rows['action']['edit_without'] = [];
    $rows['action']['delete_without'] = [];
    $rows['action']['view_without'] = [];
    $rows['action']['links_without'] = [];
    $rows["action"]["name"] = "Transfare Data Controller";
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
