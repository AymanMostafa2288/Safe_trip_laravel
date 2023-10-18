<?php
use App\Repositories\Interfaces\admin_management\AdminInterface;
use App\Models\Admin;

function table($data = [])
{
    $related_to = false;
    if (array_key_exists("related_to", $data)) {
        $related_to = $data["related_to"];
    }
    $rows = [];
    $rows = table_design($rows);
    $rows = table_head($rows);
    $rows = table_body($rows);
    $rows = table_buttons($rows, $related_to);
    $rows = table_filter($rows);
    return $rows;
}

function table_head($rows)
{
    $rows["head"] = [];
    $rows["head"]["id"] = "ID";
    $rows["head"]["name"] = "Name";
    $rows["head"]["email"] = "Email";
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "action";
    }
    return $rows;
}

function table_body($rows, $related_to = false)
{




    $filters = request()->all();
    $model=new Admin;
    $request = [];
    $request = SetStatementDB($request, $filters);
    $records_count = StatementDB($model, $request,true,true);
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
    $body = app(AdminInterface::class)->data($request);
    $body = (array) json_decode(json_encode($body), true);
    $rows["body"] = $body;
    $rows["page"] = $page;
    if (count($body) > $request["row_in_page"]) {
        $rows["pagination"] = $pagination;
    } else {
        $rows["pagination"] = ceil($records_count / $request["row_in_page"]);
    }
    $rows["main_url"] = url("dashboard/administrator/");
    $rows["records_count"] = $records_count;
    $rows["body_length"]=90;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $rows["table"] = [];
    $rows["table"]["multi_select"] = false;
    $rows["table"]["add"] = true;
    $rows["table"]["add_link"] = route("admins.create");

    $rows["table"]["delete_link"] = url("dashboard/administrator/admins/");
    $rows["table"]["edit_link"] = url("dashboard/administrator/admins/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;
    $rows["table"]["filter"] = true;
    return $rows;
}

function table_design($rows)
{
    $rows["action"] = [];
    $rows["action"]["edit"] = true;
    $rows["action"]["delete"] = true;
    $rows["action"]["view"] = false;
    $rows["action"]["pagination"] = true;
    $rows["action"]["links"] = [];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Admins Controller";
    return $rows;
}

function table_filter($rows)
{
    $filter = request()->all();
    $rows["filter"] = [
        "role_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Role",
            "name" => "role_id",
            "placeholder" => "Role",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-4",

            "options" => getValueByTableName("install_roles", ["name"], []),
            "selected" => (array_key_exists("role_id", $filter)) ? $filter["role_id"] : "",
        ],
    ];
    return $rows;
}
