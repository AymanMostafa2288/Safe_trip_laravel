<?php
function form($data = [])
{
    $fields = [];
    $fields["left_1"] = [
        "url" => [
            "input_type" => "input",
            "readonly" => true,
            "type" => "text",
            "title" => "URL",
            "name" => "url",
            "placeholder" => "URL",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("url", $data)) ? $data["url"] : old("url")
        ],
    ];
    $fields["left_2"] = [
        "web_h1" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Page H1",
            "name" => "web_h1",
            "placeholder" => "Page H1",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("web_h1", $data)) ? $data["web_h1"] : old("web_h1")
        ],
        "web_h2" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_area",
            "title" => "Page H2",
            "name" => "web_h2",
            "placeholder" => "Page H2",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("web_h2", $data)) ? $data["web_h2"] : old("web_h2")
        ],
    ];
    $fields["left_3"] = [
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'seo_breadcrumbs',
            'title'=>'Breadcrumbs',
            'name'=>'breadcrumbs',
            'options'=>form_options(),
            'values'=>(array_key_exists('breadcrumbs',$data) && $data['breadcrumbs'])?json_decode($data['breadcrumbs'],true):[],
        ],
    ];

    $fields["right_1"] = [
        "meta_title" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Title Meta Tag",
            "name" => "meta_title",
            "placeholder" => "Title Meta Tag",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("meta_title", $data)) ? $data["meta_title"] : old("meta_title")
        ],
        "meta_desc" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_area",
            "title" => "Content Meta Tag",
            "name" => "meta_desc",
            "placeholder" => "Content Meta Tag",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("meta_desc", $data)) ? $data["meta_desc"] : old("meta_desc")
        ],

        "meta_canonical" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Canonical Meta Tag",
            "name" => "meta_canonical",
            "placeholder" => "Canonical Meta Tag",
            "class" => "",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("meta_canonical", $data)) ? $data["meta_canonical"] : old("meta_canonical")
        ],

        "meta_keywords" => [
            "input_type" => "input",
            "type" => "hidden",
            "title" => "Keywords Meta Tags",
            "name" => "meta_keywords",
            "placeholder" => "Keywords Meta Tags",
            "class" => "select2_sample3",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("meta_keywords", $data)) ? $data["meta_keywords"] : old("meta_keywords")
        ],
    ];
    $fields["right_2"] = [

        "web_blog" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_editor",
            "title" => "Blog Content",
            "name" => "web_blog",
            "placeholder" => "Blog Content",
            "class" => "ckeditor",
            "around_div" => "form-group form-md-line-input",


            "value" => (array_key_exists("web_blog", $data)) ? $data["web_blog"] : old("web_blog")
        ],
    ];
    $fields["right_3"] = [
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'seo_faqs',
            'title'=>'Faqs',
            'name'=>'web_faqs',
            'options'=>form_options(),
            'values'=>(array_key_exists('web_faqs',$data) && $data['web_faqs'])?json_decode($data['web_faqs'],true):[],
        ],
    ];
    $fields["right_4"] = [
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'short_links',
            'title'=>'Short Links',
            'name'=>'web_short_links',
            'options'=>form_options(),
            'values'=>(array_key_exists('web_short_links',$data) && $data['web_short_links'])?json_decode($data['web_short_links'],true):[],
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
    $module_id = 51;
    $fields["button_save"] = true;
    $fields["button_save_edit"] = true;
    $fields["send_mail"] = false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] = true ;
        $fields["button_save_edit"] =  true;
    } else {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] = true;
        $fields["button_save_edit"] = true;
    }
    return $fields;
}

function form_attributes($fields, $id = "")
{
    if ($id == "") {
        $fields["action"] = route("seo.store");
    } else {
        $fields["action"] = route("seo.update", $id);
    }
    $fields["translate_href"] = url("dashboard/modules/seo/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 1;
    $fields["left_count"] = 3;
    $fields["module_id"] = 51;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "Main Configuration";
    $fields["icon_left_1"] = "icon-pointer";
    $fields["title_left_2"] = "Web Site Titles";
    $fields["icon_left_2"] = "icon-pointer";
    $fields["title_left_3"] = "Breadcrumbs";
    $fields["icon_left_3"] = "icon-pointer";
    $fields["title_right_1"] = "SEO Meta Management";
    $fields["icon_right_1"] = "icon-pointer";
    $fields["title_right_2"] = "Seo Blog Management";
    $fields["icon_right_2"] = "icon-pointer";
    $fields["title_right_3"] = "Seo FAQs";
    $fields["icon_right_3"] = "icon-pointer";
    $fields["title_right_4"] = "Seo Short Links";
    $fields["icon_right_4"] = "icon-pointer";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
