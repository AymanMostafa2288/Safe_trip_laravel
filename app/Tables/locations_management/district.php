<?php

use App\Repositories\Interfaces\locations_management\DistrictsInterface;

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
    $rows["head"]["name"] = "Title";
    $rows["head"]["city_id"] = "City";
    $rows["head"]["state_id"] = "State";
    $rows["head"]["country_id"] = "Country";
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "Action";
    }
    $rows['head_select']['db']=['city_id','state_id','country_id'];
    $rows['head_select']['db_option']=[
        'city_id'=>'city_name',
        'state_id'=>'state_name',
        'country_id'=>'country_name',
    ];
    $rows['head_select']['select']=[];
    $rows['head_select']['select_option']=table_option();
    return $rows;
}





function table_body($rows, $related_to = false)
{
    $filters = request()->all();
    $request = [];
    $request = SetStatementDB($request, $filters);
    $records_count = app(DistrictsInterface::class)->model->count();
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
    $request["orderBy"]=[];
    $request["orderBy"]["created_at"]="desc";

    $body = app(DistrictsInterface::class)->data($request);

    $body = (array) json_decode(json_encode($body), true);

    $rows["body"] = $body;
    $rows["page"] = $page;
    if (count($body) < $request["row_in_page"]) {
        $rows["pagination"] = $pagination;
    } else {
        $rows["pagination"] = ceil($records_count / $request["row_in_page"]);
    }
    $rows["main_url"] = url("dashboard/modules/locations_areas/");
    $rows["records_count"] = $records_count;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $rows["table"] = [];
    $rows["table"]["multi_select"] = false;
    $rows["table"]["add"] = true ;
    $rows["table"]["add_link"] = route("location.district.create");
    if ($related_to != false) {
        $rows["table"]["add_link"] = route("location.district.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/modules/locations_areas/");
    $rows["table"]["edit_link"] = url("dashboard/modules/locations_areas/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;;
    $rows["table"]["filter"] = true;
    $rows["table"]["export_excel"] = false;
$rows["table"]["bulck_action"] = false;
    return $rows;
}

function table_design($rows)
{
    $rows["action"] = [];
    $rows["action"]["edit"] = true;
    $rows["action"]["delete"] = true;
    $rows["action"]["view"] = false;
    $rows["action"]["links"] = [];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Districts Controller";
    return $rows;
}

function table_filter($rows)
{
    $filter = request()->all();
    $rows["filter"] = [
        "country_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Country",
            "name" => "country_id",
            "placeholder" => "Country",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-4",
            "options" => getValueByTableName("install_countries", ["name_en"], []),
            "selected" => (array_key_exists("country_id", $filter)) ? $filter["country_id"] : "",
        ],
        "state_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "State",
            "name" => "state_id",
            "placeholder" => "State",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-4",
            "options" => getValueByTableName("install_states", ["name_en"], []),
            "selected" => (array_key_exists("state_id", $filter)) ? $filter["state_id"] : "",
        ],
        "city_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "City",
            "name" => "city_id",
            "placeholder" => "City",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-4",
            "options" => getValueByTableName("install_cities", ["name_en"], []),
            "selected" => (array_key_exists("city_id", $filter)) ? $filter["city_id"] :'',
        ],
    ];

    return $rows;
}
function table_option(){
    $option=[];
    return $option;
}
