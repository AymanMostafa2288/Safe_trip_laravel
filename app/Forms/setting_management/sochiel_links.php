<?php


function form($data=[]){

    $fields=[];
    $media=[
        'facebook'=>'Facebook',
        'twitter'=>'Twitter',
        'instgram'=>'Instgram',
        'linkedin'=>'LinkedIn',
    ];
    $fields['right_1']=[];
    foreach($media as $key=>$value){
        $fields['right_1'][$key]=[
            "input_type" => "input",
            "type" => "text",
            "title" => $value,
            "name" => $key,
            "placeholder" => $value,
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "col" =>'col-md-6',

            "value" => (array_key_exists($key, $data)) ? $data[$key] : old($key)
        ];
    }

    $fields=form_buttons($fields);
    $fields=form_attributes($fields);
    $fields=form_design($fields);
    return $fields;
}

function form_buttons($fields){
    $fields['button_save']=true;
    $fields['button_save_edit']=false;
    $fields['send_mail']=false;
    $fields['button_clear']=false;
    $fields["custom_buttons"] = false;
    $fields["custom_buttons_tags"]=[


    ];
    return $fields;
}
function form_attributes($fields){
    $fields['action']=route('generals.store');
    $fields['method']='POST';
    $fields['class']='';
    $fields['id']='';
    $fields['right_count']=1;
    $fields['left_count']=0;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='Sochiel Media';
    $fields['icon_right_1']='icon-settings';
    return $fields;
}

function form_options(){
    $DB_options=[];
    $icon=getIcons();
    $parent=getDepartments();
    $DB_options['icon']=$icon;
    $DB_options['parent']=$parent;

    return $DB_options;
}
