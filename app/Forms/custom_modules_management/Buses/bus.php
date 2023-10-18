<?php
use App\Enum\Custom\BusStatusEnum;
use App\Enum\ActiveStatusEnum;
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
        "vehicle_number" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Vehicle Number",
            "name" => "vehicle_number",
            "placeholder" => "Vehicle Number",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("vehicle_number", $data)) ? $data["vehicle_number"] : old("vehicle_number")
        ],

        "passenger_capacity" => [
            "input_type" => "input",
            "type" => "number",
            "title" => "Passenger Capacity",
            "name" => "passenger_capacity",
            "placeholder" => "Passenger Capacity",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("passenger_capacity", $data)) ? $data["passenger_capacity"] : old("passenger_capacity")
        ],
        "status" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Status",
            "name" => "status",
            "placeholder" => "Status",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => BusStatusEnum::options(),
            "selected" => (array_key_exists("status", $data)) ? $data["status"] : old("status")
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
        "vehicle_license" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Vehicle License",
            "name" => "vehicle_license",
            "placeholder" => "Vehicle License",
            "class" => "",
            "col" => 'col-md-6',
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("vehicle_license", $data)) ? $data["vehicle_license"] : old("vehicle_license")
        ],
        "color_code" => [
            "input_type" => "input",
            "type" => "color",
            "title" => "Color",
            "name" => "color_code",
            "placeholder" => "Color",
            "col" => 'col-md-6',
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("color_code", $data)) ? $data["color_code"] : old("color_code")
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";
    }
    $fields = form_buttons($fields);
    $fields = (empty($data)) ? form_attributes($fields) : form_attributes($fields, $data["id"]);
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields)
{
    $module_id = 5;
    $fields["custom_buttons"] = false;
    $fields["translate"] = false;
    $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["send_mail"] = false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["button_save"] = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    $fields["action"] = ($id == "") ? route("buses.store"): route("buses.update", $id);
    $fields["translate_href"] = url("dashboard/modules/buses/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 5;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Info";
    $fields["icon_left_1"] = "icon-pointer";
    $fields["title_right_1"] = "Details";
    $fields["icon_right_1"] = "icon-pointer";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
