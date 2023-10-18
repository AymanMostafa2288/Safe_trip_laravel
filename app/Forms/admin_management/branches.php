<?php

use App\Repositories\Interfaces\builder_management\BranchInterface;

function form($data = [])
{

    $fields = [];
    $fields['right_1']=[
        'address'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Address',
            'name'=>'address',
            'placeholder'=>'Address',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-12',
            'below_div'=>'',
            'value'=>(array_key_exists('address',$data))?$data['address']:old('address')
        ],
        'note'=>[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>6],
            'title'=>'Note',
            'name'=>'note',
            'placeholder'=>'Note',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-12',
            'below_div'=>'',
            'value'=>(array_key_exists('note',$data))?$data['note']:''
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
        'phone'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Phone',
            'name'=>'phone',
            'placeholder'=>'Phone',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('phone',$data))?$data['phone']:old('phone')
        ],

    ];
    $fields['form_edit']=false;
    if(!empty($data)){
        $fields['form_edit']=true;
    }


    if(empty($data)){
        $fields = form_attributes($fields);
        $fields = form_buttons($fields);
    }else{
        $fields = form_attributes($fields,$data['id']);
        $fields = form_buttons($fields,$data);
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
    $fields['button_save'] = checkAdminPermission($permissions,'Branches','specific');
    $fields['button_save_edit'] = checkAdminPermission($permissions,'Branches','specific');
    $fields['send_mail'] = false;
    $fields['button_clear'] = false;
    $fields['custom_buttons'] = false;

    return $fields;
}
function form_attributes($fields,$id='')
{
    $permissions=getPermissions();
    if($id==''){
        $fields["action"] = route("branches.store");
    }else{
        $fields["action"] = route("branches.update",$id);
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
    $fields['title_right_1']='Branch Information';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_left_1']='Branch CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
