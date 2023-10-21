<?php

use App\Repositories\Interfaces\custom_modules_management\Trips\TripInterface;
use App\Enum\Custom\TripStatusEnum;

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
    $rows["head"]["route_id"] = "Route";
    $rows["head"]["status"] = "Status";
    $rows["head"]["day"] = "Day";
    $rows["head"]["time_start"] = "Start At";
    $rows["head"]["time_end"] = "End At";
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "Action";
    }
    $rows['head_select'] = [
        'db'            => ['route_id'],
        'db_option'     => ['route_id'=>'route_name_'.getDashboardCurrantLanguage()],
        'select'        => ['status'],
        'select_option' => table_option()
    ];
    return $rows;
}

function table_body($rows, $related_to = false)
{
    $filters = request()->all();
    $request = [];
    $request = SetStatementDB($request, $filters);
    $records_count = app(TripInterface::class)->model->count();
    $page = 1;
    $offset = 0;
    $pagination = false;
    if ((request()->page && request()->page >= 1) || $records_count > config('var.rows_table_count')) {
        $page = (request()->page)?request()->page:1;
        $offset = ($page * $request["row_in_page"]) - $request["row_in_page"];
        $pagination = ceil($records_count / $request["row_in_page"]);
    }
    $request["page"] = $page;
    $request["offset"] = $offset;
    $request["orderBy"] = [];
    $request["orderBy"]["created_at"] = "desc";
    $body = app(TripInterface::class)->data($request);
    $body = (array)json_decode(json_encode($body), true);
    $rows["body"] = $body;
    $rows["page"] = $page;
    $rows["pagination"] = $pagination;
    $rows["main_url"] = url("dashboard/modules/trips/");
    $rows["records_count"] = $records_count;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $module_id = 9;
    $rows["table"] = [];
    $rows["table"]["multi_select"] = true;
//    $rows["table"]["add"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $rows["table"]["add"] = false;
    $rows["table"]["add_link"] = route("trips.create");
    if ($related_to != false) {
        $rows["table"]["add_link"] = route("trips.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/modules/trips/");
    $rows["table"]["edit_link"] = url("dashboard/modules/trips/");
    $rows["table"]["view_link"] = url("dashboard/modules/trips/");

    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;
    $rows["table"]["filter"] = true;
    $rows["table"]["export_excel"] = false;
    return $rows;
}

function table_design($rows)
{
    $module_id = 9;
    $rows["action"] = [];
    $rows["action"]["edit"] = false;
//    $rows["action"]["edit"] = (checkAdminPermission("show", $module_id)) ? true : false;
//    $rows["action"]["delete"] = (checkAdminPermission("delete", $module_id)) ? true : false;
    $rows["action"]["delete"] = false;
    $rows["action"]["view"] = (checkAdminPermission("show", $module_id)) ? true : false;;
    $rows["action"]["links"] = [];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Trips";
    return $rows;
}

function table_filter($rows)
{
    $filter = request()->all();
    $rows["filter"] = [
        "created_from" => [
            "input_type" => "input",
            "type" => "date",
            "title" => "Day",
            "name" => "day",
            "placeholder" => "Day",
            "class" => "",
            "around_div" => "form-group form-md-line-input col-md-6",
            "below_div" => "",
            "value" => (array_key_exists("day", $filter)) ? $filter["day"] : "",
        ],
        "route_id" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Route",
            "name" => "route_id",
            "placeholder" => "",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-6",
            "options" =>getValueByTableName("bus_routes", ["name_".getDashboardCurrantLanguage()], ["is_active" => \App\Enum\ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("route_id", $filter)) ? $filter["route_id"] : "",
        ],
        "status" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Status",
            "name" => "status",
            "placeholder" => "",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-6",
            "options" => TripStatusEnum::options(),
            "selected" => (array_key_exists("status", $filter)) ? $filter["status"] : "",
        ],


    ];

    return $rows;
}
function table_option(){
    $option                 = [];
    $option['status']       = TripStatusEnum::options();
    $option['status_color'] = [
        TripStatusEnum::NOT_YET        => "gray",
        TripStatusEnum::WORKING        => "blue",
        TripStatusEnum::FINISHED       => "green",
    ];
    return $option;
}
