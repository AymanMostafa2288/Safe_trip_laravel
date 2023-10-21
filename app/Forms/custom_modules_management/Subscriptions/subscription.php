<?php
use App\Enum\ActiveStatusEnum;
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
        "family_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Family",
            "name" => "family_id",
            "placeholder" => "Family",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("bus_families", ["code"], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("family_id", $data)) ? $data["family_id"] : old("family_id")
        ],
        "package_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Package",
            "name" => "package_id",
            "placeholder" => "Package",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("bus_packages", ["name_ar"], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("package_id", $data)) ? $data["package_id"] : old("package_id")
        ],
    ];
    $fields["right_1"] = [
        "count_of_price" => [
            "input_type" => "input",
            "type" => "number",
            "title" => "Count Of Trips",
            "name" => "count_of_price",
            "placeholder" => "Count Of Trips",
            "class" => "",
            "col"=>"col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("count_of_price", $data)) ? $data["count_of_price"] : old("count_of_price")
        ],
        "price" => [
            "input_type" => "input",
            "type" => "number",
            "decimal" => true,
            "title" => "Price",
            "name" => "price",
            "placeholder" => "Price",
            "class" => "",
            "col"=>"col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("price", $data)) ? $data["price"] : old("price")
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
    $module_id = 10;
    $fields["button_save"] = true;
    $fields["button_save_edit"] = true;
    $fields["send_mail"] = false;
    $fields["button_clear"] = false;
    $fields["translate"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["button_save"] = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    } else {
        $fields["custom_buttons"] = false;
        $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("subscriptions.store");
    } else {
        $fields["action"] = route("subscriptions.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/subscriptions/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 10;
    $fields["left_corner"] = true;
    $fields["show_button"] = false;
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
