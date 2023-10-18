<?php
use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\WorkerTypeEnum;
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
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
        "school_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "School",
            "name" => "school_id",
            "placeholder" => "School",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" =>  getValueByTableName("bus_schools", ["name_".getDashboardCurrantLanguage()], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("school_id", $data)) ? $data["school_id"] : old("school_id")
        ],
        'active' => [
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
        "address_to" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Address",
            "name" => "address_to",
            "placeholder" => "Address",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("address_to", $data)) ? $data["address_to"] : old("address_to")
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
    $fields["right_2"] = [
        'fields'=> [
            'folder'  =>'tracking',
            'input_type'=>'multi_record',
            'type'=>'route_sign',
            'title'=>'Sign',
            'name'=>'route_sign',
            'options'=>form_options(),
            'values'=>(array_key_exists('value',$data))?$data['value']['fields_record']:[],
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";
    }
    $fields = form_buttons($fields);
    $fields = (empty($data))?form_attributes($fields):form_attributes($fields, $data["id"]);
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields)
{
    $module_id = 7;
    $fields["send_mail"] = false;
    $fields["custom_buttons"] = false;
    $fields["translate"] = false;
    $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["translate"] = (checkAdminPermission("translate", $module_id)) ? true : false;
        $fields["button_save"] = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    }

    return $fields;
}

function form_attributes($fields, $id = ""){

    $fields["action"] = ($id == "") ? route("routes.store") : route("routes.update", $id);
    $fields["translate_href"] = url("dashboard/modules/routes/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 2;
    $fields["left_count"] = 1;
    $fields["module_id"] = 7;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Info";
    $fields["icon_left_1"] = "icon-target";
    $fields["title_right_1"] = "Location";
    $fields["icon_right_1"] = "icon-target";
    $fields["title_right_2"] = "Sign";
    $fields["icon_right_2"] = "icon-target";

    return $fields;
}

function form_options()
{
    $DB_options = [];
    $DB_options['buses']       = getValueByTableName("bus_buses", ["vehicle_number"], ["is_active" => ActiveStatusEnum::ACTIVE]);
    $DB_options['drivers']     = getValueByTableName("bus_workers", ["code"], ["is_active" => ActiveStatusEnum::ACTIVE,"type" => WorkerTypeEnum::DRIVER]);
    $DB_options['supervisors'] = getValueByTableName("bus_workers", ["code"], ["is_active" => ActiveStatusEnum::ACTIVE,"type" => WorkerTypeEnum::SUPERVISOR]);
    return $DB_options;
}
