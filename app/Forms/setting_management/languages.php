<?php

function form($data = [])
{
    $fields = [];

    $fields['right_1']=[
        'slug'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Slug',
            'name'=>'slug',
            'placeholder'=>'Slug',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('slug',$data))?$data['slug']:old('slug')
        ],
        'main'=>[
            'input_type'=>'select',
            'title'=>'Is Main ?',
            'name'=>'is_main',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'options'=>[
                1=>'Yes',
                0=>'No',
            ],
            'selected'=>(array_key_exists('is_main',$data))?$data['is_main']:1
        ],
    ];
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
    $fields['form_edit']=false;
    if(!empty($data)){
        $fields['form_edit']=true;
    }
    $fields = form_buttons($fields);

    if(empty($data)){
        $fields = form_attributes($fields);
    }else{
        $fields = form_attributes($fields,$data['id']);
    }
    $fields = form_design($fields);
    return $fields;
}

function form_buttons($fields)
{
    $fields['button_save'] = true;
    $fields['button_save_edit'] = false;
    $fields['send_mail'] = false;
    $fields['button_clear'] = false;
    $fields['custom_buttons'] = false;

    return $fields;
}
function form_attributes($fields,$id='')
{
    $permissions=getPermissions();
    if($id==''){
        $fields["action"] = route("languages.store");
    }else{
        $fields["action"] = route("languages.update",$id);
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
    $fields['title_right_1']='Language Information';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_left_1']='Language CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
