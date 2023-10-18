<?php

use App\Enum\NotificationTypeEnum;
use App\Repositories\Interfaces\builder_management\ModuleInterface;

function form($data = [])
{
    $fields = [];
    $req=[];
    $req['select']=['id','name'];
    $modules=app(ModuleInterface::class)->data($req);
    $modules_option=[];
    $modules_option=getOptions($modules_option,$modules,'name');
    $fields["left_1"] = [
        "name" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Name",
            "name" => "name",
            "placeholder" => "Name",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("name", $data)) ? $data["name"] : old("name")
        ],

        'icon'=>[
            'input_type'=>'select',
            'title'=>'Icon',
            'name'=>'icon',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=> getIcons(),
            'selected'=>(array_key_exists('icon',$data))?$data['icon']:1
        ],

        'table_db'=>[
            'input_type'=>'select',
            'title'=>'DataBase Table',
            'name'=>'table_db',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>getDBTable(),
            'selected'=>(array_key_exists('table_db',$data))?$data['table_db']:1
        ],

        "field_name" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Field Name",
            "name" => "field_name",
            "placeholder" => "Field Name",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("field_name", $data)) ? $data["field_name"] : old("field_name")
        ],

        "field_value" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Field Value",
            "name" => "field_value",
            "placeholder" => "Field Value",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("field_value", $data)) ? $data["field_value"] : old("field_value")
        ],
        'type'=>[
            'input_type'=>'select',
            'title'=>'Notification Type',
            'name'=>'type',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>NotificationTypeEnum::options(),
            'selected'=>(array_key_exists('type',$data))?$data['type']:NotificationTypeEnum::NOTIFICATION
        ],
        'module_id'=>[
            'input_type'=>'select',
            'title'=>'Related With Module',
            'name'=>'module_id',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$modules_option,
            'selected'=>(array_key_exists('module_id',$data))?$data['module_id']:''
        ],
    ];
    $fields["right_1"] = [
        "message" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_area",
            "title" => "Message",
            "name" => "message",
            "placeholder" => "Message",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("message", $data)) ? $data["message"] : old("message")
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

    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields)
{
    $module_id = 1;
    $fields["button_save"] = true;
    $fields["button_save_edit"] = true;
    $fields["send_mail"] = false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    } else {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("notifications.store");
    } else {
        $fields["action"] = route("notifications.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/notifications/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 1;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Configurations";
    $fields["icon_left_1"] = "";
    $fields["title_right_1"] = "Message";
    $fields["icon_right_1"] = "";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
