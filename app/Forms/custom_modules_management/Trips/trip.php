<?php
use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\TripStatusEnum;
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = ["route_id" => [
        "input_type" => "select",
        "type" => "select_search",
        "title" => "Route",
        "name" => "route_id",
        "placeholder" => "Route",
        "class" => "select2_category",
        "around_div" => "form-group form-md-line-input",
        "options" => getValueByTableName("bus_routes", ["name_".getDashboardCurrantLanguage()], ["is_active" => ActiveStatusEnum::ACTIVE]),
        "selected" => (array_key_exists("route_id", $data)) ? $data["route_id"] : old("route_id")
    ],
        "driver_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Driver",
            "name" => "driver_id",
            "placeholder" => "Driver",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("bus_workers", ["name"], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("driver_id", $data)) ? $data["driver_id"] : old("driver_id")
        ],
        "supervisor_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Supervisor",
            "name" => "supervisor_id",
            "placeholder" => "Supervisor",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("bus_workers", ["name"], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("supervisor_id", $data)) ? $data["supervisor_id"] : old("supervisor_id")
        ],

        "trip_id" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Trip",
            "name" => "trip_id",
            "placeholder" => "Trip",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("trip_id", $data)) ? $data["trip_id"] : old("trip_id")
        ],
        "bus_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Bus",
            "name" => "bus_id",
            "placeholder" => "Bus",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("bus_buses", ["vehicle_number"], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("bus_id", $data)) ? $data["bus_id"] : old("bus_id")
        ],
        "status" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Status",
            "name" => "status",
            "placeholder" => "Status",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => TripStatusEnum::options(),
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
        "day" => [
            "input_type" => "input",
            "type" => "date",
            "title" => "Day",
            "name" => "day",
            "placeholder" => "Day",
            "class" => "",
            "col" => "col-md-12",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("day", $data)) ? $data["day"] : old("day")
        ],
        "time_start" => [
            "input_type" => "input",
            "type" => "time",
            "title" => "Start At",
            "name" => "time_start",
            "placeholder" => "Start At",
            "class" => "",
            "col" => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("time_start", $data)) ? $data["time_start"] : old("time_start")
        ],
        "time_end" => [
            "input_type" => "input",
            "type" => "time",
            "title" => "End At",
            "name" => "time_end",
            "placeholder" => "End At",
            "class" => "",
            "col" => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("time_end", $data)) ? $data["time_end"] : old("time_end")
        ],
        "actual_time_start" => [
            "input_type" => "input",
            "type" => "time",
            "attributes"=> ['readonly'=>true],
            "title" => "Actual Trip Start At",
            "name" => "actual_time_start",
            "placeholder" => "Actual Time Start At",
            "class" => "",
            "col" => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("actual_time_start", $data)) ? $data["actual_time_start"] : old("actual_time_start")
        ],
        "actual_time_end" => [
            "input_type" => "input",
            "type" => "time",
            "attributes"=> ['readonly'=>true],
            "title" => "Actual Trip End At",
            "name" => "actual_time_start",
            "placeholder" => "Actual Trip End At",
            "class" => "",
            "col" => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("actual_time_start", $data)) ? $data["actual_time_start"] : old("actual_time_start")
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
    $module_id = 9;
    $fields["button_save"] = false;
    $fields["button_save_edit"] = false;
//
    $fields["send_mail"] = false;
    $fields["translate"] =  false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;

    }else{
        $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("trips.store");
    } else {
        $fields["action"] = route("trips.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/trips/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 9;
    $fields["left_corner"] = true;
    $fields["show_button"] = false;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Info";
    $fields["icon_left_1"] = "icon-target";
    $fields["title_right_1"] = "Details";
    $fields["icon_right_1"] = "icon-settings";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
