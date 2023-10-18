<?php
use App\Repositories\Interfaces\admin_management\RoleInterface;

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
    $rows["head"]["name"] = "Title";
    $rows["head"]["created_at"] = "Created At";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {
        $rows["head"]["action_buttons"] = "action";
    }
    return $rows;
}

function table_body($rows, $related_to = false)
{
    $request = [];
    $request["select"] = [];
    $request["page"] = "";
    $request["row_in_page"] = 20;
    $body = app(RoleInterface::class)->data($request);

    $body = (array) json_decode(json_encode($body), true);
    $rows["body"] = $body;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $rows["table"] = [];
    $rows["table"]["multi_select"] = false;
    $rows["table"]["add"] = true;
    $rows["table"]["add_link"] = route("roles.create");
    if ($related_to != false) {
        $rows["table"]["add_link"] = route("roles.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/administrator/roles/");
    $rows["table"]["edit_link"] = url("dashboard/administrator/roles/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;
    $rows["table"]["filter"] = false;
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
    $rows["action"]["name"] = "Roles Controller";
    return $rows;
}

function table_filter($rows)
{
    $rows["filter"] = [];
    return $rows;
}
