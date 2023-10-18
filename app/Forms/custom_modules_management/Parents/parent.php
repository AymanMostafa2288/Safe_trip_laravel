<?php
use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\ParentRelations;
use App\Enum\Custom\GanderEnum;
use Illuminate\Support\Str;

function form($data = []){

    $fields            = [];
    $fields["left_1"]  = [
        "name"=>[
            "input_type"=>"input",
            "type"=>"text",
            "title"=>"Family Name",
            "name"=>"name",
            "placeholder"=>"Family Name",
            "class"=>"",
            "around_div"=>"form-group form-md-line-input",
            "value"=>(array_key_exists("name",$data))?$data["name"]:old("name")
        ],
        "code"=>[
            "input_type"=>"input",
            "type"=>"text",
            "title"=>"Family Code",
            "name"=>"code",
            "placeholder"=>"Family Code",
            "class"=>"",
            "around_div"=>"form-group form-md-line-input",
            "attributes"=>['readonly'=>true],
            "value"=>(array_key_exists("code",$data))?$data["code"]:randomNumber(2,start_with: 'SA_'),
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
        'fields'=> [
            'folder'  =>'tracking',
            'input_type'=>'multi_record',
            'type'=>'family_member',
            'title'=>'Members',
            'name'=>'family_members',
            'options'=>form_options(),
            'values'=>(array_key_exists('members',$data))?$data['members']:[],
        ],
    ];
    $fields["form_edit"] = false;
    if(!empty($data)){
        $fields["form_edit"]=true;
        $fields["link_custom"]="";
    }
    $fields = form_buttons($fields);
    $fields = (empty($data)) ? form_attributes($fields):form_attributes($fields,$data["id"]);
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields){

    $module_id=1;
    $fields["button_save"]      = true;
    $fields["button_save_edit"] = true;
    $fields["send_mail"]        = false;
    $fields["button_clear"]     = false;
    $fields["translate"]        = false;
    if ($fields["form_edit"]) {
        $fields["custom_buttons"]   = false;
        $fields["button_save"]      = (checkAdminPermission("update",$module_id))?true:false;
        $fields["button_save_edit"] = (checkAdminPermission("update",$module_id))?true:false;
    } else {
        $fields["custom_buttons"]   = false;
        $fields["button_save"]      = (checkAdminPermission("insert",$module_id))?true:false;
        $fields["button_save_edit"] = (checkAdminPermission("insert",$module_id))?true:false;
    }
    return $fields;
}

function form_attributes($fields,$id=""){

    if($id=="")
    $fields["action"] = route("parents.store");
    else
    $fields["action"] = route("parents.update",$id);

    $fields["translate_href"] = url("dashboard/modules/parents/translate/".$id);
    $fields["method"]         = "POST";
    $fields["class"]          = "";
    $fields["id"]             = $id;
    $fields["right_count"]    = 1;
    $fields["left_count"]     = 1;
    $fields["module_id"]      = 1;
    $fields["left_corner"]    = true;
    $fields["show_button"]    = true;
    return $fields;
}

function form_design($fields){
    $fields["title_left_1"]  = "Info";
    $fields["icon_left_1"]   = "icon-users";
    $fields["title_right_1"] = "Members";
    $fields["icon_right_1"]  = "icon-users";
    return $fields;
}

function form_options(){
    $DB_options = [];
    $DB_options['parent_relations'] = ParentRelations::options();
    $DB_options['gander']           = GanderEnum::options();
    $DB_options['active']           = ActiveStatusEnum::options(reverse:true);
    return $DB_options;
}
