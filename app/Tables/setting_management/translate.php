<?php
use App\Repositories\Interfaces\setting_management\LanguageInterface;

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
    $rows["head"]["name"] = "Title";
    if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true || !empty($rows['action']['links']) ) {
        $rows["head"]["action_buttons"] = "Files";
    }
    return $rows;
}

function table_body($rows, $related_to = false)
{
    $request = [];
    $request["select"] = [];
    $request["page"] = "";
    $request["row_in_page"] = 20;
    $body = app(LanguageInterface::class)->data($request);

    $body = (array) json_decode(json_encode($body), true);
    $rows["body"] = $body;
    return $rows;
}

function table_buttons($rows, $related_to = false)
{
    $rows["table"] = [];
    $rows["table"]["multi_select"] = false;
    $rows["table"]["add"] = false;
    $rows["table"]["add_link"] = route("languages.create");
    if ($related_to != false) {
        $rows["table"]["add_link"] = route("languages.create") . "?related_to=" . $related_to;
    }
    $rows["table"]["delete_link"] = url("dashboard/setting/languages/");
    $rows["table"]["edit_link"] = url("dashboard/setting/languages/");
    $rows["table"]["status_change"] = false;
    $rows["table"]["delete_all"] = false;
    $rows["table"]["filter"] = false;
    return $rows;
}

function table_design($rows)
{
    $rows["action"] = [];
    $rows["action"]["edit"] = false;
    $rows["action"]["delete"] = false;
    $rows["action"]["view"] = false;
    $rows["action"]["pagination"] = false;
    $rows["action"]["links"] = [
        ['href'=>route('dashboard_one_lang',['file'=>'content']),'param'=>['slug'],'name'=>'Content'],
        ['href'=>route('dashboard_one_lang',['file'=>'globals']),'param'=>['slug'],'name'=>'Global'],
        ['href'=>route('dashboard_one_lang',['file'=>'validations']),'param'=>['slug'],'name'=>'Validation'],
        ['href'=>route('dashboard_one_lang',['file'=>'messages']),'param'=>['slug'],'name'=>'Message']
    ];
    $rows["action"]["edit_without"] = [];
    $rows["action"]["delete_without"] = [];
    $rows["action"]["view_without"] = [];
    $rows["action"]["links_without"] = [];
    $rows["action"]["name"] = "Translate Controller";
    return $rows;
}

function table_filter($rows)
{
    $rows["filter"] = [];
    return $rows;
}
