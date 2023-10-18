<?php
function form($data = [])
{
    $fields = [];

    $fields["left_1"] = [
        "name_en" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Title (English)",
            "name" => "name_en",
            "placeholder" => "Title (English)",
            "class" => "",
            "around_div" => "form-group form-md-line-input",

            "value" => (array_key_exists("name_en", $data)) ? $data["name_en"] : old("name_en"),
        ],
        "name_ar" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Title (Arabic)",
            "name" => "name_ar",
            "placeholder" => "Title (Arabic)",
            "class" => "",
            "around_div" => "form-group form-md-line-input",

            "value" => (array_key_exists("name_ar", $data)) ? $data["name_ar"] : old("name_ar"),
        ],
    ];

    $fields["right_1"] = [
        'image'=>[
            'input_type'=>'upload_image',
            'title'=>'Image',
            'name'=>'image',
            'placeholder'=>'',
            'class'=>'',
            'col'=>'col-md-3',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('image',$data))?readFileStorage($data['image']):''
        ],
        "code" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Code",
            "name" => "code",
            "placeholder" => "Code",
            "class" => "",
            'col'=>'col-md-12',
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("code", $data)) ? $data["code"] : old("code"),
        ],

    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";}

    if (empty($data)) {
        $fields = form_attributes($fields);
        $fields = form_buttons($fields);
    } else {
        $fields = form_attributes($fields, $data["id"]);
        $fields = form_buttons($fields,$data);
    }

    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields,$data=[])
{
    $permissions=2;
    if(empty($data)){
        $permissions=1;
    }
    $fields['button_save'] = checkAdminPermission($permissions,'Countries','specific');
    $fields['button_save_edit'] = checkAdminPermission($permissions,'Countries','specific');
    $fields["send_mail"] =false;;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
    } else {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("location.country.store");
    } else {
        $fields["action"] = route("location.country.update", $id);
    }
    $fields["translate_href"] = url("dashboard/location/locations_management/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 9;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Configurations";
    $fields["icon_left_1"] = "icon-pointer";
    $fields["title_right_1"] = "Code And Image";
    $fields["icon_right_1"] = "icon-pointer";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
