<?php
use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
function form($data = []){

    $fields = [];
    $fields["left_1"] = [
        "logo" => [
            "input_type" => "upload_image",
            "type" => "image",
            "title" => "Image",
            "name" => "logo",
            "placeholder" => "",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("logo", $data)) ? readFileStorage($data["logo"]) : ""
        ],
        "code" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Code",
            "name" => "code",
            "placeholder" => "Code",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "attributes"=>['readonly'=>true],
            "value"=>(array_key_exists("code",$data))?$data["code"]:randomNumber(2,start_with: 'SA_'),
        ],
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
        "national_id" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "National ID",
            "name" => "national_id",
            "placeholder" => "National ID",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("national_id", $data)) ? $data["national_id"] : old("national_id")
        ],
    ];
    $fields["left_2"] = [
        "mobile" => [
            "input_type"  => "input",
            "type"        => "text",
            "title"       => "Phone",
            "name"        => "mobile",
            "placeholder" => "Phone",
            "class"       => "",
            "around_div"  => "form-group form-md-line-input",
            "value"       => (array_key_exists("mobile", $data)) ? $data["mobile"] : old("mobile")
        ],
        "password" => [
            "input_type"  => "input",
            "type"        => "password",
            "title"       => "Password",
            "name"        => "password",
            "placeholder" => "Password",
            "class"       => "",
            "around_div"  => "form-group form-md-line-input",
            "value"       =>''
        ],
        'active' => [
            'input_type'  => 'select',
            'title'       => 'Is Active ?',
            'name'        => 'is_active',
            'placeholder' => '',
            'class'       => 'select2_category',
            'around_div'  => 'form-group form-md-line-input',
            'below_div'   => '',
            'options'     => ActiveStatusEnum::options(reverse:true),
            'selected'    => (array_key_exists('is_active',$data))?$data['is_active']:1
        ],
    ];
    $fields["right_1"] = [
        "driving_license" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Driving License",
            "name" => "driving_license",
            "placeholder" => "Driving License",
            "class" => "",
            "col" => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("driving_license", $data)) ? $data["driving_license"] : old("driving_license")
        ],
        "gander" => [
            "input_type"  => "select",
            "type"        => "select",
            "title"       => "Gander",
            "name"        => "gander",
            "placeholder" => "Gander",
            "col"         => "col-md-6",
            "class"       => "select2_category",
            "around_div"  => "form-group form-md-line-input",
            "options"     => GanderEnum::options(),
            "selected"    => (array_key_exists("gander", $data)) ? $data["gander"] : old("gander")
        ],
        "note" => [
            "input_type"  => "textarea",
            "attributes"  => ["rows" => 8],
            "type"        => "text_area",
            "title"       => "Note",
            "name"        => "note",
            "placeholder" => "Note",
            "class"       => "",
            "around_div"  => "form-group form-md-line-input",
            "value"       => (array_key_exists("note", $data)) ? $data["note"] : old("note")
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"]   = true;
        $fields["link_custom"] = "";
    }
    $fields = form_buttons($fields);
    $fields = (empty($data)) ? form_attributes($fields) : form_attributes($fields, $data["id"]);
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields){
    $module_id                  = 3;
    $fields["button_save"]      = true;
    $fields["button_save_edit"] = true;
    $fields["send_mail"]        = false;
    $fields["button_clear"]     = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"]   = false;
        $fields["translate"]        = false;
        $fields["button_save"]      = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    } else {
        $fields["custom_buttons"]   = false;
        $fields["translate"]        = false;
        $fields["button_save"]      = (checkAdminPermission("insert", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = ""){

    $fields["action"]         = ($id == "")? route("drivers.store"):route("drivers.update", $id);
    $fields["translate_href"] = url("dashboard/modules/drivers/translate/" . $id);
    $fields["method"]         = "POST";
    $fields["class"]          = "";
    $fields["id"]             = $id;
    $fields["right_count"]    = 1;
    $fields["left_count"]     = 2;
    $fields["module_id"]      = 3;
    $fields["left_corner"]    = true;
    $fields["show_button"]    = true;
    return $fields;
}

function form_design($fields){

    $fields["title_left_1"] = "Info";
    $fields["icon_left_1"]  = "icon-notebook";
    $fields["title_left_2"] = "Account";
    $fields["icon_left_2"]  = "icon-notebook";
    $fields["title_right_1"] = "Details";
    $fields["icon_right_1"]  = "icon-notebook";
    return $fields;
}

function form_options(){

    $DB_options = [];
    return $DB_options;
}

