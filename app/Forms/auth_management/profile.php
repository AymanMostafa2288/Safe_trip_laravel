<?php

use App\Repositories\Interfaces\admin_management\RoleInterface;
use App\Repositories\Interfaces\admin_management\BranchInterface;
use App\Repositories\Interfaces\builder_management\AdminInterface;

function form($data = [])
{
    $fields = [];
    $fields['right_1']=[
        'first_name'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'First Name',
            'name'=>'first_name',
            'placeholder'=>'First Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('first_name',$data))?$data['first_name']:old('first_name')
        ],
        'last_name'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Last Name',
            'name'=>'last_name',
            'placeholder'=>'Last Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('last_name',$data))?$data['last_name']:old('last_name')
        ],


    ];
    $fields['left_1']=[
        'username'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Username',
            'name'=>'username',
            'placeholder'=>'Username',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('username',$data))?$data['username']:old('username')
        ],

        'email'=>[
            'input_type'=>'input',
            'type'=>'email',
            'title'=>'Email',
            'name'=>'email',
            'placeholder'=>'Email',
            'attributes'=>['readonly'=>'readonly'],
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('email',$data))?$data['email']:old('email')
        ],
        'password'=>[
            'input_type'=>'input',
            'type'=>'password',
            'title'=>'Password',
            'name'=>'password',
            'placeholder'=>'Password',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>''
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
    $fields["action"] = route("post_dashboard_profile",$id);
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
    $fields['title_right_1']='User Details';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_left_1']='User Information';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
