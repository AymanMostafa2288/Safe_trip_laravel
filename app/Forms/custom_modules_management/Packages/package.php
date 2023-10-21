<?php
use App\Enum\ActiveStatusEnum;
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

        "route_id" => [
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

        "count_of_trip" => [
            "input_type" => "input",
            "type" => "number",
            "title" => "Count Of Trips",
            "name" => "count_of_trip",
            "placeholder" => "Count Of Trips",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("count_of_trip", $data)) ? $data["count_of_trip"] : old("count_of_trip")
        ],

        "price" => [
            "input_type" => "input",
            "type" => "number",
            "title" => "Price",
            "name" => "price",
            "decimal" => true,
            "placeholder" => "Price",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("price", $data)) ? $data["price"] : old("price")
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
    if(request()->route_id){
        unset($fields["left_1"]['route_id']);
    }
    $fields["right_1"] = ["note_ar" => [
        "input_type" => "textarea",
        "attributes" => ["rows" => 4],
        "type" => "text_area",
        "title" => "Note (Arabic)",
        "name" => "note_ar",
        "placeholder" => "Note (Arabic)",
        "class" => "",
        "around_div" => "form-group form-md-line-input",
        "value" => (array_key_exists("note_ar", $data)) ? $data["note_ar"] : old("note_ar")
    ],
        "note_en" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_area",
            "title" => "Note (English)",
            "name" => "note_en",
            "placeholder" => "Note (English)",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("note_en", $data)) ? $data["note_en"] : old("note_en")
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";
    }
    $fields = form_buttons($fields,$data);
    if (empty($data)) {
        $fields = form_attributes($fields);
    } else {
        $fields = form_attributes($fields, $data["id"]);
    }


    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields,$data)
{
    $module_id = 8;
    $fields["send_mail"] = false;
    $fields["button_clear"] = false;
    $fields["translate"] = false;
    $fields["custom_buttons"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = true;
        $fields['custom_buttons_tags'] = [
            [
                'type' => 'link',
                'blank'=>true,
                'href'=>route('subscriptions.index').'?package_id='.$data['id'],
                'color'=>'btn-primary',
                'name'=>'Subscription'
            ]
        ];
        $fields["button_save"] = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    } else {
        $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    $fields["action"] = ($id == "") ? route("packages.store") : route("packages.update", $id);
    $fields["translate_href"] = url("dashboard/modules/packages/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 8;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    if(request()->route_id){
        $fields['hidden_inputs']=['route_id'=>request()->route_id];
    }
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Info";
    $fields["icon_left_1"] = "icon-wallet";
    $fields["title_right_1"] = "Details";
    $fields["icon_right_1"] = "icon-wallet";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
