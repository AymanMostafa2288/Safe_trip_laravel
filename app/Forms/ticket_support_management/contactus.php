<?php
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
        "name" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Full Name",
            "name" => "name",
            "placeholder" => "Full Name",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "readonly"=>true,
            "value" => (array_key_exists("name", $data)) ? $data["name"] : old("name")
        ],

        "email" => [
            "input_type" => "input",
            "type" => "email",
            "title" => "Email",
            "name" => "email",
            "placeholder" => "Email",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "readonly"=>true,
            "value" => (array_key_exists("email", $data)) ? $data["email"] : old("email")
        ],

        "phone" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Phone",
            "name" => "phone",
            "placeholder" => "Phone",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "readonly"=>true,
            "value" => (array_key_exists("phone", $data)) ? $data["phone"] : old("phone")
        ],
    ];
    $fields["right_1"] = [
        "title" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Subject",
            "name" => "title",
            "placeholder" => "Subject",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "readonly"=>true,
            "value" => (array_key_exists("title", $data)) ? $data["title"] : old("title")
        ],
        "message" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 12],
            "type" => "text_area",
            "title" => "Message",
            "name" => "message",
            "placeholder" => "Message",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "readonly"=>true,
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
        $fields["translate"] = (checkAdminPermission("translate", $module_id)) ? true : false;
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
        $fields["action"] = route("contact-us.store");
    } else {
        $fields["action"] = route("contact-us.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/contact-us/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 1;
    $fields["left_corner"] = true;
    $fields["show_button"] = false;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Sender Information";
    $fields["icon_left_1"] = "icon-envelope";
    $fields["title_right_1"] = "Sender Message";
    $fields["icon_right_1"] = "icon-envelope";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
