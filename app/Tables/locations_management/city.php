<?php
use App\Repositories\Interfaces\locations_management\CitiesInterface;

function table($data = [])
{
    $related_to = false;
    if (array_key_exists("related_to", $data)) {
        $related_to = $data["related_to"];
    }
    $rows = [];
    $rows = tableDesign($rows);
    $rows = tableBody($rows);
    $rows = tableHead($rows);
    $rows = tableButtons($rows, $related_to);
    $rows = tableFilter($rows);
    return $rows;
}

function tableHead($rows)
{
    $rows["head"] = [];
    $rows["head"]["id"] = "ID";
    $rows["head"]["name"] = "Title";
    $rows["head"]["country_id"] = "Country";
    $rows["head"]["state_id"] = "State";
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "Action";
    }

    $rows['head_select']['db']=['country_id','state_id'];
    $rows['head_select']['db_option']=[
        'country_id'=>'country_name_en',
        'state_id'=>'state_name_en',
    ];
    $rows['head_select']['select']=[''];
    $rows['head_select']['select_option']=tableOption();
    return $rows;
}

function tableBody($rows, $related_to = false){

    $filters = request()->all();
    $request = [];
    $request = SetStatementDB($request, $filters);
    $records_count = app(CitiesInterface::class)->model->count();
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
    $body = app(CitiesInterface::class)->data($request);
    $body = (array) json_decode(json_encode($body), true);

    $rows["body"] = $body;
    $rows["page"] = $page;


    if (count($body) < $request["row_in_page"]) {
        $rows["pagination"] = $pagination;
    } else {
        $rows["pagination"] = ceil($records_count / $request["row_in_page"]);
    }
    $rows["main_url"] = route("location.city.index");
    $rows["records_count"] = $records_count;
    return $rows;
}

function tableButtons($rows, $related_to = false)
{
    $module_id=10;
    $rows["table"] = [];
    $rows["table"]["multi_select"] = true;
    $rows["table"]["add"] = true;
    $rows["table"]["add_link"] = route("location.city.create");
    if ($related_to != false) {
        $rows["table"]["add_link"] = route("location.city.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/modules/locations_city/");
    $rows["table"]["edit_link"] = url("dashboard/modules/locations_city/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;;
    $rows["table"]["filter"] = true;
    $rows["table"]["export_excel"] = false;
    $rows["table"]["bulck_action"] = false;
    return $rows;
}

function tableDesign($rows)
{
    $module_id=10;
    $rows["action"] = [];
    $rows["action"]["edit"] = true;
    $rows["action"]["delete"] = true;
    $rows["action"]["view"] = false;
    $rows["action"]["links"] = [];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Cities Controller";
    return $rows;
}

function tableFilter($rows)
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
            "around_div" => "form-group form-md-line-input col-md-6",
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
            "around_div" => "form-group form-md-line-input col-md-6",
            "options" => getValueByTableName("install_states", ["name_en"], []),
            "selected" => (array_key_exists("state_id", $filter)) ? $filter["state_id"] : "",
        ],
    ];

    return $rows;
}

function tableOption(){
    $option=[];
    return $option;
}
