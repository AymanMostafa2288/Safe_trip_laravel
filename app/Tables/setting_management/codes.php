<?php
use App\Repositories\Interfaces\setting_management\CodeInterface;

function table($data = [])
{
    $related_to = false;
    if (array_key_exists("related_to", $data)) {
        $related_to = $data["related_to"];
    }
    $rows = [];
    $rows = table_design($rows);
    $rows = table_head($rows);
    $rows = table_body($rows, $related_to);
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


    $filters=request()->all();

    $request = [];
    $request=SetStatementDB($request,$filters);
    $records_count=app(CodeInterface::class)->model->count();

    $page=1;
    $offset=0;
    $pagination=false;
    if(request()->page && request()->page >= 1){
        $page=request()->page;
        $offset=($page * $request["row_in_page"])-$request["row_in_page"];
    }
    $pagination=ceil($records_count / $request["row_in_page"]);
    $request["page"] = $page;
    $request["offset"] = $offset;
    $body = app(CodeInterface::class)->data($request);
    $body = (array) json_decode(json_encode($body), true);
    $rows["body"] = $body;

    if($records_count > $request["row_in_page"]){
        $rows["pagination"] = $pagination;
    }else{
        $rows["pagination"] = 1;
    }

    $parameters=$_GET;
    unset($parameters['page']);
    if(http_build_query($parameters)!=''){
        $rows["main_url"] = url()->current().'?'.http_build_query($parameters);
    }else{
        $rows["main_url"] = url()->current();
    }

    $rows["records_count"] = $records_count;

    $rows["page"] = $page;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $rows["table"] = [];
    $rows["table"]["multi_select"] = false;
    $rows["table"]["add"] = true;
    $rows["table"]["add_link"] = route("codes.create");

    $rows["table"]["delete_link"] = url("dashboard/setting/codes/");
    $rows["table"]["edit_link"] = url("dashboard/setting/codes/");
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
    $rows["action"]["name"] = "Codes Controller";
    return $rows;
}

function table_filter($rows)
{
    $rows["filter"] = [];
    return $rows;
}
