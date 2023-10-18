<?php

use App\Repositories\Interfaces\task_management\TasksInterface;

function table($data = [])
{
    $related_to = false;
    if (array_key_exists("related_to", $data)) {
        $related_to = $data["related_to"];
    }
    $rows = [];
    $rows = table_design($rows);
    $rows = table_body($rows);
    $rows = table_head($rows);
    $rows = table_buttons($rows, $related_to);
    $rows = table_filter($rows);
    return $rows;
}

function table_head($rows)
{
    $rows["head"] = [];
    $rows["head"]["id"] = "ID";
    $rows["head"]["title"] = "Title";
    $rows["head"]["status"] = "Stage";
    $rows["head"]["type"] = "Priority";
    $rows["head"]["admin_id"] = "Created By";
    $rows["head"]["admin_to"] = "Created To";
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "Action";
    }

    $rows['head_select']['db']=[
        'admin_id',
        'admin_to',
    ];
    $rows['head_select']['db_option']=[
        'admin_id'=>'createdBy_email',
        'admin_to'=>'createdTo_email',
    ];
    $rows['head_select']['select']=['status','type'];
    $rows['head_select']['select_option']=table_option();
    return $rows;
}

function table_body($rows, $related_to = false)
{
    $filters = request()->all();
    $request = [];
    $request = SetStatementDB($request, $filters);
    $records_count = app(TasksInterface::class)->model->count();
    $page = 1;
    $offset = 0;
    $pagination = false;
    if (request()->page && request()->page >= 1) {
        $page = request()->page;
        $offset = ($page * $request["row_in_page"]) - $request["row_in_page"];
        $pagination = ceil($records_count / $request["row_in_page"]);
    }
    $request["page"] = $page;
    $request["offset"] = $offset;
    $body = app(TasksInterface::class)->data($request);
    $body = (array) json_decode(json_encode($body), true);
    $rows["body"] = $body;
    $rows["page"] = $page;
    if ($body > $request["row_in_page"]) {
        $rows["pagination"] = $pagination;
    } else {
        $rows["pagination"] = $pagination;
    }
    $rows["main_url"] = url("dashboard/tasks/tasks/");
    $rows["records_count"] = $records_count;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $module_id = 27;
    $rows["table"] = [];
    $rows["table"]["multi_select"] = true;
    $rows["table"]["add"] =  true ;
    if (array_key_exists('board_id', $_GET)) {
        $rows["table"]["add_link"] = route("tasks.create") . "?board_id=" . $_GET['board_id'];
    } else {
        $rows["table"]["add"] = false;
        $rows["table"]["add_link"] = route("tasks.create");
    }

    if ($related_to != false) {
        $rows["table"]["add_link"] = route("tasks.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/tasks/tasks/");
    $rows["table"]["edit_link"] = url("dashboard/tasks/tasks/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] =true ;;
    $rows["table"]["filter"] = false;
    $rows["table"]["export_excel"] = false;
    $rows["table"]["bulck_action"] = false;
    return $rows;
}

function table_design($rows)
{
    $module_id = 27;
    $rows["action"] = [];
    $rows["action"]["edit"] =true ;
    $rows["action"]["delete"] = true ;
    $rows["action"]["view"] = false;
    $rows["action"]["links"] = [];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Tasks Controller";
    return $rows;
}

function table_filter($rows)
{
    $filter = request()->all();
    $rows["filter"] = [
        "created_from" => [
            "input_type" => "input",
            "type" => "date",
            "title" => "Created From",
            "name" => "created_from",
            "placeholder" => "Created From",
            "class" => "",
            "around_div" => "form-group form-md-line-input col-md-6",
            "below_div" => "",
            "value" => (array_key_exists("created_from", $filter)) ? $filter["created_from"] : "",
        ],
        "created_to" => [
            "input_type" => "input",
            "type" => "date",
            "title" => "Created To",
            "name" => "created_to",
            "placeholder" => "Created To",
            "class" => "",
            "around_div" => "form-group form-md-line-input col-md-6",
            "below_div" => "",
            "value" => (array_key_exists("created_to", $filter)) ? $filter["created_to"] : "",
        ],
        "id" => [
            "input_type" => "input",
            "type" => "number",
            "title" => "ID",
            "name" => "id",
            "placeholder" => "ID",
            "class" => "",
            "around_div" => "form-group form-md-line-input col-md-6",
            "below_div" => "",
            "value" => (array_key_exists("id", $filter)) ? $filter["id"] : "",
        ],
    ];

    return $rows;
}
function table_option(){
    $option=[];
    $option['type']=[
        "low" => "Low",
        "meddim" => "Meddim",
        "high" => "High",
    ];
    $option['type_color']=[
        "low" => "default",
        "meddim" => "success",
        "high" => "danger",
    ];
    $stages=getValueByTableName("install_boards", ["stages"], ['id'=>$_GET['board_id']],[],false,true);
    $stages=json_decode($stages->stages,true)['title'];
    $option['status']=$stages;

    return $option;
}
