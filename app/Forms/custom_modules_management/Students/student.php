<?php
use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
function form($data = [])
{
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
            "attributes"=>['readonly'=>true],
            "placeholder" => "Code",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("code", $data)) ? $data["code"] :randomNumber(length: 2,start_with: 'SA_'),
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
        "family_id" => [
            "input_type" => "select",
            "type" => "select_search",
            "title" => "Family",
            "name" => "family_id",
            "placeholder" => "Family",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => getValueByTableName("bus_families", ["code" , "name"], ["is_active" => ActiveStatusEnum::ACTIVE]),
            "selected" => (array_key_exists("family_id", $data)) ? $data["family_id"] : old("family_id")
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
        "phone" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Phone",
            "name" => "phone",
            "placeholder" => "Phone",
            "class" => "",
            "col"   => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("phone", $data)) ? $data["phone"] : old("phone")
        ],
        "gander" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Gander",
            "name" => "gander",
            "placeholder" => "Gander",
            "class" => "select2_category",
            "col"   => "col-md-6",
            "around_div" => "form-group form-md-line-input",
            "options" => GanderEnum::options(),
            "selected" => (array_key_exists("gander", $data)) ? $data["gander"] : old("gander")
        ],
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
            "input_type" => "textarea",
            "attributes" => ["rows" => 8],
            "type" => "text_area",
            "title" => "Note",
            "name" => "note",
            "placeholder" => "Note",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("note", $data)) ? $data["note"] : old("note")
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
    $module_id = 2;
    $fields["send_mail"] = false;
    $fields["translate"] = false;
    $fields["button_clear"] = false;
    $fields["custom_buttons"] = false;
    $fields["button_save"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    $fields["button_save_edit"] = (checkAdminPermission("insert", $module_id)) ? true : false;
    if ($fields["form_edit"]) {
        $fields["button_save"] = (checkAdminPermission("update", $module_id)) ? true : false;
        $fields["button_save_edit"] = (checkAdminPermission("update", $module_id)) ? true : false;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("students.store");
    } else {
        $fields["action"] = route("students.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/students/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 1;
    $fields["module_id"] = 2;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Info";
    $fields["icon_left_1"] = "icon-users";
    $fields["title_right_1"] = "Details";
    $fields["icon_right_1"] = "icon-users";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
