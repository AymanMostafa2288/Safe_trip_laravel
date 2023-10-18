<?php
use App\Repositories\Interfaces\setting_management\SeoInterface;

function table($data = [])
{
    $related_to = false;

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
    $rows["head"]["url"] = "Url";
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
    $records_count=app(SeoInterface::class)->model->count();
    $rows["body_length"]=255;
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
    $body = app(SeoInterface::class)->data($request);
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
    $rows["table"]["add"] = false;
    $rows["table"]["add_link"] = route("seo.create");

    $rows["table"]["delete_link"] = url("dashboard/setting/seo/");
    $rows["table"]["edit_link"] = url("dashboard/setting/seo/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;
    $rows["table"]["filter"] = true;
    return $rows;
}

function table_design($rows)
{
    $rows["action"] = [];
    $rows["action"]["edit"] = true;
    $rows["action"]["delete"] = false;
    $rows["action"]["view"] = false;
    $rows["action"]["pagination"] = true;
    $rows["action"]["links"] = [];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Seo Controller";
    return $rows;
}

function table_filter($rows)
{
    $filter = request()->all();
    $rows["filter"] = [
        "url" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "URL",
            "name" => "url",
            "placeholder" => "URL",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input col-md-6",
            "value" => (array_key_exists("country_id", $filter)) ? $filter["url"] : "",
        ],
    ];
    return $rows;
}
