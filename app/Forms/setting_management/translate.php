<?php


function form($data=[]){
    $fields=[];
    $fields['right_1']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'translate_words',
            'title'=>'Words',
            'name'=>'words',
            'options'=>form_options(),
            'values'=>(array_key_exists('words',$data))?$data['words']:[],
            'button_show'=>false

        ],
    ];
    $fields=form_buttons($fields);
    $fields=form_attributes($fields,$data);
    $fields=form_design($fields);
    return $fields;
}

function form_buttons($fields){
    $fields['button_save']=true;
    $fields['button_save_edit']=false;
    $fields['send_mail']=false;
    $fields['button_clear']=false;
    return $fields;
}
function form_attributes($fields,$data=[]){
    $fields['action']=route('dashboard_update_lang',['file'=>$data['file'],'slug'=>$data['language']]);
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
    $fields['title_right_1']='App Logos';
    $fields['icon_right_1']='icon-settings';

    return $fields;
}

function form_options(){
    $DB_options=[];
    return $DB_options;
}
