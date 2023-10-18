<?php

use App\Repositories\Interfaces\admin_management\RoleInterface;
use App\Repositories\Interfaces\admin_management\BranchInterface;
use App\Repositories\Interfaces\builder_management\AdminInterface;

function form($data = [])
{

    $request=[];
    $request['select']=['id','name'];
    $roles=app(RoleInterface::class)->data($request);
    $roles=getOptions([],$roles,'name');
    $request=[];
    $request['select']=['id','name'];
    $branches=app(BranchInterface::class)->data($request);
    $branches=getOptions([],$branches,'name');


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
        'role'=>[
            'input_type'=>'select',
            'title'=>'Role',
            'name'=>'role_id',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'options'=>$roles,
            'selected'=>(array_key_exists('role_id',$data))?$data['role_id']:0
        ],
        // 'branch'=>[
        //     'input_type'=>'select',
        //     'title'=>'Branch',
        //     'name'=>'branch_id',
        //     'placeholder'=>'',
        //     'class'=>'select2_category',
        //     'around_div'=>'form-group form-md-line-input',
        //     'col'=>'col-md-6',
        //     'below_div'=>'',
        //     'options'=>$branches,
        //     'selected'=>(array_key_exists('branch_id',$data))?$data['branch_id']:0
        // ],
        // 'type'=>[
        //     'input_type'=>'select',
        //     'title'=>'Type',
        //     'name'=>'type',
        //     'placeholder'=>'',
        //     'class'=>'select2_category',
        //     'around_div'=>'form-group form-md-line-input',
        //     'col'=>'col-md-6',
        //     'below_div'=>'',
        //     'options'=>[
        //         'employee'=>'Employee',
        //         'manger'=>'Manger',
        //         'super_manger'=>'Super Manger',
        //     ],
        //     'selected'=>(array_key_exists('type',$data))?$data['type']:'employee'
        // ],
        // 'is_developer'=>[
        //     'input_type'=>'select',
        //     'title'=>'Is Developer ?',
        //     'name'=>'is_developer',
        //     'placeholder'=>'',
        //     'class'=>'select2_category',
        //     'around_div'=>'form-group form-md-line-input',
        //     'col'=>'col-md-6',
        //     'below_div'=>'',
        //     'options'=>[
        //         1=>'Yes',
        //         0=>'No',
        //     ],
        //     'selected'=>(array_key_exists('is_developer',$data))?$data['is_developer']:0
        // ],
    ];
    $permissions=[
        'role_section'=>'Role & Permissions Section',
        'branch_section'=>'Branches Section',
        'admin_section'=>'Administrator Section',
        'logs_section'=>'Logs Section',
        'report_section'=>'Reports Section',
        'translate_section'=>'Translation Section',
        'task_section'=>'Task Section',
        'accounnt_evaluation'=>'Accounnt Evaluation',
        'notification_feature_property'=>'Show Feature Property Notification',
        'notification_contract_remander'=>'Show Contract Clients Notification',
        'notification_follow_customer_remander'=>'Show Customer Follow Notification',
    ];
    $fields['right_2'] =[
        'fields_action'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'specific_permissions',
            'options'=>$permissions,
            'selected'=>(array_key_exists('specific_permissions',$data) && $data['specific_permissions']!=null)?json_decode($data['specific_permissions'],true):[]
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
        'active'=>[
            'input_type'=>'select',
            'title'=>'Is Active ?',
            'name'=>'is_active',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                1=>'Yes',
                0=>'No',
            ],
            'selected'=>(array_key_exists('is_active',$data))?$data['is_active']:1
        ],
        'email'=>[
            'input_type'=>'input',
            'type'=>'email',
            'title'=>'Email',
            'name'=>'email',
            'placeholder'=>'Email',
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


    if(empty($data)){
        $fields = form_attributes($fields);
        $fields = form_buttons($fields,[]);
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
    $fields['button_save'] = checkAdminPermission($permissions,'Admin','specific');
    $fields['button_save_edit'] = checkAdminPermission($permissions,'Admin','specific');
    $fields['send_mail'] = false;
    $fields['button_clear'] = false;
    $fields['custom_buttons'] = false;

    return $fields;
}
function form_attributes($fields,$id='')
{
    $permissions=getPermissions();
    if($id==''){
        $fields["action"] = route("admins.store");
    }else{
        $fields["action"] = route("admins.update",$id);
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
    $fields['title_right_1']='Admin Details';
    $fields['icon_right_1']='icon-settings ';



    $fields['title_left_1']='Admin Information';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options()
{
    $DB_options = [];
    return $DB_options;
}
