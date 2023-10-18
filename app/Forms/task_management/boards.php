<?php
function form($data = [])
{
    $fields = [];
    $admins_selected=[];
    if (!empty($data)) {
        $admins_selected = selectedOption('admin_id','install_admins_boards','board_id',$data['id']);
    }
    $fields["left_1"] = [
        "title" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Title",
            "name" => "title",
            "placeholder" => "Title",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("title", $data)) ? $data["title"] : old("title")
        ],
    ];
    $fields["left_2"] = [
        'admins'=>[
            'input_type'=>'multi_record',
            'type'=>'task_admins',
            'title'=>'Admins',
            'name'=>'admins',
            'options'=>form_options(),
            'values'=>$admins_selected,
        ],
    ];
    $fields["right_1"] = [
        'stages'=>[
            'input_type'=>'multi_record',
            'type'=>'task_stages',
            'title'=>'Stages',
            'name'=>'stages',
            'options'=>form_options(),
            'values'=>(array_key_exists("stages", $data)) ? json_decode($data["stages"],true) : [],
        ],
    ];
    $fields["right_2"] = [
        'types'=>[
            'input_type'=>'multi_record',
            'type'=>'task_types',
            'title'=>'Types',
            'name'=>'types',
            'options'=>form_options(),
            'values'=>(array_key_exists("types", $data) && $data["types"]) ? json_decode($data["types"],true) : [],
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";
    }
    $fields = form_buttons($fields);
    if (empty($data)) {
        $fields = form_attributes($fields);
    } else {
        $fields = form_attributes($fields, $data["id"]);
    }
    $fields["related_codes"] = [];
    if (!empty($data) && !empty($fields["related_codes"])) {
        $fields["related_codes_values"] = $data["codes"];
    }
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields)
{
    $module_id = 54;
    $fields["button_save"] = true;
    $fields["button_save_edit"] = true;
    $fields["send_mail"] =false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] =true ;
        $fields["button_save_edit"] = true ;
    } else {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] = true ;
        $fields["button_save_edit"] = false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("boards.store");
    } else {
        $fields["action"] = route("boards.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/account_boards/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 2;
    $fields["left_count"] = 2;
    $fields["module_id"] = 54;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Information";
    $fields["icon_left_1"] = "icon-target";
    $fields["title_left_2"] = "Admins";
    $fields["icon_left_2"] = "icon-target";
    $fields["title_right_1"] = "Stages";
    $fields["icon_right_1"] = "icon-target";
    $fields["title_right_2"] = "Types";
    $fields["icon_right_2"] = "icon-target";
    return $fields;
}

function form_options()
{
    $DB_options = [];

    $DB_options['admins']=getValueByTableName("install_admins", ["email"], []);
    return $DB_options;
}
