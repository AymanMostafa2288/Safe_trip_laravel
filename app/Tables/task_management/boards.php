<?php

use App\Repositories\Interfaces\task_management\BoardsInterface;

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
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "Action";
    }
    return $rows;
}

function table_body($rows, $related_to = false)
{
    $filters = request()->all();
    $request = [];
    $request = SetStatementDB($request, $filters);
    $records_count = app(BoardsInterface::class)->model->count();

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
    $request["orderBy"] = [];
    $request["orderBy"]["created_at"] = "desc";
    $body = app(BoardsInterface::class)->data($request);

    $body = (array) json_decode(json_encode($body), true);
    $rows["body"] = $body;
    $rows["page"] = $page;
    if ($body > $request["row_in_page"]) {
        $rows["pagination"] = $pagination;
    } else {
        $rows["pagination"] = $pagination;
    }
    $rows["main_url"] = url("dashboard/tasks/boards/");
    $rows["records_count"] = $records_count;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $rows["table"] = [];
    $rows["table"]["multi_select"] = true;
    $rows["table"]["add"] =  true;
    $rows["table"]["add_link"] = route("boards.create");
    if ($related_to != false) {
        $rows["table"]["add_link"] = route("boards.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/tasks/boards/");
    $rows["table"]["edit_link"] = url("dashboard/tasks/boards/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;;
    $rows["table"]["filter"] = false;
    $rows["table"]["export_excel"] = false;
    return $rows;
}

function table_design($rows)
{
    $module_id = 54;
    $rows["action"] = [];
    $rows["action"]["edit"] =  true;
    $rows["action"]["delete"] = true ;
    $rows["action"]["view"] = false;
    $rows["action"]["links"] = [
        ['href'=>route("tasks.index"),'param'=>[['board_id'=>'id']],'name'=>'Tasks']
    ];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Boards Controller";
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
