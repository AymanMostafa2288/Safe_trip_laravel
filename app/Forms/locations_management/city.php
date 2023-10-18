<?php
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
        "name" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Title",
            "name" => "name",
            "placeholder" => "Title",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("name", $data)) ? $data["name"] : old("name"),
        ],
        "country_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Country",
            "name" => "country_id",
            "placeholder" => "Country",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("install_countries", ["name_en"], []),
            "selected" => (array_key_exists("country_id", $data)) ? $data["country_id"] : old("country_id"),
        ],
        "state_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "State",
            "name" => "state_id",
            "placeholder" => "State",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("install_states", ["name_en"], []),
            "selected" => (array_key_exists("state_id", $data)) ? $data["state_id"] : old("state_id"),
        ],
    ];
    $fields["right_1"] = [
        "note" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_area",
            "title" => "Note",
            "name" => "note",
            "placeholder" => "Note",
            "class" => "",
            "around_div" => "form-group form-md-line-input",

            "value" => (array_key_exists("note", $data)) ? $data["note"] : old("note"),
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";}

    if (empty($data)) {
        $fields = form_buttons($fields);
        $fields = form_attributes($fields);
    } else {
        $fields = form_buttons($fields, $data);
        $fields = form_attributes($fields, $data["id"]);
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
    $fields['button_save'] = checkAdminPermission($permissions,'Cities','specific');
    $fields['button_save_edit'] = checkAdminPermission($permissions,'Cities','specific');
    $fields["send_mail"] = false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["custom_buttons_tags"]=[];
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
        $fields["action"] = route("location.city.store");
    } else {
        $fields["action"] = route("location.city.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/locations_city/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 10;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Information";
    $fields["icon_left_1"] = "icon-pointer";
    $fields["title_right_1"] = "Notes";
    $fields["icon_right_1"] = "icon-pointer";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
