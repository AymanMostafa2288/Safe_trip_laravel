<?php

use App\Repositories\Interfaces\setting_management\CodeInterface;

function form($data = [])
{
    $fields=[];

    $fields['left_1']=[
        'name'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Name',
            'name'=>'name',
            'placeholder'=>'Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('name',$data))?$data['name']:old('name')
        ],


    ];

    $fields['right_1']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'codes_body',
            'title'=>'Enum Body',
            'name'=>'enum_body',
            'options'=>form_options(),
            'values'=>(array_key_exists('enum_body',$data) && $data['enum_body'])?json_decode($data['enum_body'],true):[],
        ],
    ];

    $fields['form_edit']=false;
    if(!empty($data)){
        $fields['form_edit']=true;
    }


    if(empty($data)){
        $fields = form_buttons($fields);
        $fields = form_attributes($fields);
    }else{
        $fields = form_buttons($fields,$data);
        $fields = form_attributes($fields,$data['id']);
    }
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields,$data=[])
{
    $fields['button_save'] = true;
    $fields['button_save_edit'] = false;
    $fields['send_mail'] = false;
    $fields['button_clear'] = false;
    if($fields['form_edit']){
        $fields['custom_buttons'] = true;
        $fields['custom_buttons_tags']=[
            ['type'=>'link','color'=>'blue','href'=>route('codes.EnumCreator',$data['id']),'name'=>'Create File','blank'=>false]
        ];
    }else{
        $fields['custom_buttons'] = false;
    }


    return $fields;
}
function form_attributes($fields,$id='')
{
    $permissions=getPermissions();
    if($id==''){
        $fields["action"] = route("codes.store");
    }else{
        $fields["action"] = route("codes.update",$id);
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 1;
    $fields['left_count'] = 1;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_right_1']='Enum Body';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_left_1']='Enum CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options()
{
    $DB_options = [];

    return $DB_options;
}
