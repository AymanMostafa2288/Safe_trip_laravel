<?php
use App\Enum\ActiveStatusEnum;
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
        "logo" => [
            "input_type" => "upload_image",
            "type" => "image",
            "title" => "Logo",
            "name" => "logo",
            "placeholder" => "",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("logo", $data)) ? readFileStorage($data["logo"]) : ""
        ],
        "name_ar" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Name (Arabic)",
            "name" => "name_ar",
            "placeholder" => "Name (Arabic)",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("name_ar", $data)) ? $data["name_ar"] : old("name_ar")
        ],
        "name_en" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Name (English)",
            "name" => "name_en",
            "placeholder" => "Name (English)",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("name_en", $data)) ? $data["name_en"] : old("name_en")
        ],
        "phone" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Phone",
            "name" => "phone",
            "placeholder" => "Phone",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("phone", $data)) ? $data["phone"] : old("phone")
        ],
        "email" => [
            "input_type" => "input",
            "type" => "email",
            "title" => "Email",
            "name" => "email",
            "placeholder" => "Email",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("email", $data)) ? $data["email"] : old("email")
        ],
        'active'=>[
            'input_type'=>'select',
            'title'=>'Is Active ?',
            'name'=>'is_active',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=> ActiveStatusEnum::options(reverse:true),
            'selected'=>(array_key_exists('is_active',$data))?$data['is_active']:1
        ],
    ];
    $fields["right_1"] = [
        "address" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Address",
            "name" => "address",
            "placeholder" => "Address",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("address", $data)) ? $data["address"] : old("address")
        ],
        "note" => [
            "input_type"  => "textarea",
            "attributes"  => ["rows" => 8],
            "type"        => "text_area",
            "title"       => "Note",
            "name"        => "about",
            "placeholder" => "Note",
            "class"       => "",
            "around_div"  => "form-group form-md-line-input",
            "value"       => (array_key_exists("about", $data)) ? $data["about"] : old("note")
        ],
        "location" => [
            "input_type" => "maps",
            "type" => "maps",
            "name" => "location",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("location", $data)) ? $data["location"] : old("location")
        ],
    ];

    $fields["form_edit"] = false;

    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";
    }
    $fields = form_buttons($fields);
    $fields = (empty($data)) ? form_attributes($fields) :form_attributes($fields, $data["id"]);
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields){

    $module_id = 6;
    $fields["custom_buttons"]   = false;
    $fields["translate"]        = false;
    $fields["button_save"]      = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["send_mail"]        = false;
    $fields["button_clear"]     = false;
    if ($fields["form_edit"]) {
        $fields["button_save"]      = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = ""){

    $fields["action"]         = ($id == "")? route("schools.store"):route("schools.update", $id);
    $fields["translate_href"] = url("dashboard/modules/schools/translate/" . $id);
    $fields["method"]         = "POST";
    $fields["class"]          = "";
    $fields["id"]             = $id;
    $fields["right_count"]    = 1;
    $fields["left_count"]     = 1;
    $fields["module_id"]      = 6;
    $fields["left_corner"]    = true;
    $fields["show_button"]    = true;
    return $fields;
}

function form_design($fields){

    $fields["title_left_1"]  = "Info";
    $fields["icon_left_1"]   = "icon-volume-1";
    $fields["title_right_1"] = "Details";
    $fields["icon_right_1"]  = "icon-volume-2";
    return $fields;
}

function form_options(){

    $DB_options = [];
    return $DB_options;
}
