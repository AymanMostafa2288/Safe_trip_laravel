<?php
function form($data = [])
{
    $fields = [];
    $stages=getValueByTableName("install_boards", ["stages"], ['id'=>$_GET['board_id']],[],false,true);
    $stages_name=json_decode($stages->stages,true)['name'];
    $stages=json_decode($stages->stages,true)['title'];
    $stages=array_combine($stages_name,$stages);



    $types=getValueByTableName("install_boards", ["types"], ['id'=>$_GET['board_id']],[],false,true);
     if($types->types){
         if(!empty(json_decode($types->types,true))){
             $types_name=json_decode($types->types,true)['name'];
              $types=json_decode($types->types,true)['title'];
              $types=array_combine($types_name,$types);
         }else{
             $types=[];
         }

     }else{
         $types=[];
     }

    $comments=[];
    if(array_key_exists("id", $data)){
        $comments=getValueByTableName('install_tasks_comments',['comment','mention_to'],['task_id'=>$data['id']],[],true);
    }





    $fields["left_1"] = [
        "title" => [
            "input_type" => "input",
            "type" => "text",
            "title" => "Title",
            "name" => "title",
            "placeholder" => "Title",
            "class" => "",
            "around_div" => "form-group form-md-line-input",

            "value" => (array_key_exists("title", $data)) ? $data["title"] : old("title"),
        ],

        "status" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Stage",
            "name" => "status",
            "placeholder" => "Stage",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => $stages,
            "selected" => (array_key_exists("status", $data)) ? $data["status"] : old("status"),
        ],
        "type" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Type",
            "name" => "type",
            "placeholder" => "Type",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => $types,
            "selected" => (array_key_exists("type", $data)) ? $data["type"] : old("type"),
        ],
        "priority" => [
            "input_type" => "select",
            "type" => "select",
            "title" => "Periorty",
            "name" => "priority",
            "placeholder" => "Periorty",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => [
                "low" => "Low",
                "meddim" => "Meddim",
                "high" => "High",
            ],
            "selected" => (array_key_exists("priority", $data)) ? $data["priority"] : old("priority"),
        ],
        "admin_to" => [
            "input_type" => "select",
            "type" => "elect_search",
            "title" => "Admins",
            "name" => "admin_to",
            "placeholder" => "Select Admin",
            "class" => "select2_category",
            "around_div" => "form-group form-md-line-input",
            "options" => form_options()['admins'],
            "selected" => (array_key_exists("admin_to", $data)) ? $data["admin_to"] :'',
        ],
        "finished_at" => [
            "input_type" => "input",
            "type" => "date",
            "title" => "Finished At",
            "name" => "finished_at",
            "placeholder" => "Finished At",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("finished_at", $data)) ? date('Y-m-d',strtotime($data["finished_at"])) : old("finished_at"),
        ],
    ];
    $fields["right_1"] = [
        "description" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_editor",
            "title" => "Description",
            "name" => "description",
            "placeholder" => "Description",
            "class" => "ckeditor",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("description", $data)) ? $data["description"] : old("description"),
        ],
    ];
    $fields["right_2"] = [
        "images" => [
            "input_type" => "upload_multi_image",
            "title" => "Main Image",
            "name" => "images",
            "limit" => 8,
            "maxSize" => 2097152,
            "value" => (array_key_exists("images", $data) && $data['images']) ? readFileStorage($data["images"],true) : [],
        ],
    ];
    $fields["right_3"] = [
        'comments'=>[
            'input_type'=>'multi_record',
            'type'=>'task_comments',
            'title'=>'Comments',
            'name'=>'comments',
            'options'=>form_options(),
            'values'=>$comments,
        ],
    ];
    $fields["form_edit"] = false;
    if (!empty($data)) {
        $fields["form_edit"] = true;
        $fields["link_custom"] = "";}
    $fields = form_buttons($fields);
    if (empty($data)) {
        $fields = form_attributes($fields,'',$_GET['board_id']);
    } else {
        $fields = form_attributes($fields, $data["id"],$data['board_id'],$data['admin_id']);
    }
    $fields["related_codes"] = [];
    if (!empty($data) && !empty($fields["related_codes"])) {
        $fields["related_codes_values"] = $data["codes"];
    }
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields)
{
    $module_id = 27;
    $fields["button_save"] = true;
    $fields["button_save_edit"] = false;
    $fields["send_mail"] =false;
    $fields["button_clear"] = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"] = false;
        $fields["translate"] =  false;
        $fields["button_save"] =  true ;
    } else {
        $fields["custom_buttons"] = false;
        $fields["translate"] = false;
        $fields["button_save"] = true ;
    }

    return $fields;
}

function form_attributes($fields, $id = "",$board_id='',$main_admin='')
{
    if ($id == "") {
        $fields["action"] = route("tasks.store").'?board_id='.$board_id;
    } else {
        $fields["action"] = route("tasks.update", $id).'?board_id='.$board_id;
    }
    $fields["translate_href"] = url("dashboard/tasks/tasks/translate/" . $id);
    $fields["method"] = "POST";
    $fields["class"] = "";
    $fields["id"] = $id;
    $fields["right_count"] = 3;
    $fields["left_count"] = 1;
    $fields["module_id"] = 27;
    $fields["left_corner"] = true;
    $fields["show_button"] = true;
    if($main_admin==''){
        $admin_id=auth()->guard('admin')->id();
    }else{
        $admin_id=$main_admin;
    }
    $fields['hidden_inputs']=[
        'board_id'=>$board_id,
        'admin_id'=>$admin_id,

    ];
    return $fields;
}

function form_design($fields)
{
    $fields["title_left_1"] = "information";
    $fields["icon_left_1"] = "icon-info";
    $fields["title_right_1"] = "description";
    $fields["icon_right_1"] = "icon-info";
    $fields["title_right_2"] = "images";
    $fields["icon_right_2"] = "icon-info";
    $fields["title_right_3"] = "Comments";
    $fields["icon_right_3"] = "icon-info";
    return $fields;
}

function form_options()
{
    $DB_options = [];
    $admin_ids=DB::table('install_admins_boards')
    ->select(['admin_id'])
    ->where('board_id',$_GET['board_id'])
    ->get()
    ->pluck('admin_id')
    ->toArray();
    $admins=DB::table('install_admins')
    ->select('id','email')
    ->whereIn('id',$admin_ids)
    ->get()->pluck('email','id')->toArray();

    $DB_options['admins']=$admins;
    return $DB_options;
}
