<?php

use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\builder_management\NotificationInterface;
use App\Repositories\Interfaces\builder_management\ReportInterface;

function form($data = [])
{
    $permissions=getPermissions();
    $tables=getDBTable();

    $req=[];

    $reports=app(ReportInterface::class)->data($req,'*',true);
    $notifications=app(NotificationInterface::class)->data($req,'*',true);


    $reports_option=[];
    $reports_option=getOptions($reports_option,$reports,'name');

    $notification_option=[];
    $notification_option=getOptions($notification_option,$notifications,'name');

    $req['select']=['id','name'];
    $modules=app(ModuleInterface::class)->data($req);
    $modules_option=[];
    $modules_option=getOptions($modules_option,$modules,'name');
    $module_permissions_selected=[];

    $spasfic_permissions_selected=[];
    $report_permissions_selected=[];
    $notification_permissions_selected=[];
    if(!empty($data)){
        $module_permissions_selected=getPermissions($data['id']);
        $spasfic_permissions_selected=getPermissions($data['id'],'specific');
        $report_permissions_selected=getPermissions($data['id'],'reports');
        $notification_permissions_selected=getPermissions($data['id'],'notifications');
    }

    $fields = [];
    $count=1;
    foreach($permissions as $permission){

        $selected=[];
        if(array_key_exists($permission['module_id'],$module_permissions_selected)){
            $selected=$module_permissions_selected[$permission['module_id']]['permissions'];
            $selected=array_keys($selected);
        }

        $fields['right_'.$count]=[
            'fields_action'=>[
                'input_type'=>'checkbox',
                'type'=>'inline', // list
                'name'=>'permissions['.$permission['module_id'].']',
                'options'=>$permission['permissions'],
                'selected'=>$selected,
            ],

        ];
        $count++;
    }

    $spasfic_permissions=config('var.spasfic_permissions');
    foreach($spasfic_permissions as $key=>$permission){
        $selected=[];
        if(array_key_exists($key,$spasfic_permissions_selected)){
            $selected=$spasfic_permissions_selected[$key];

        }
        $fields['right_'.$count]=[
            'fields_action'=>[
                'input_type'=>'checkbox',
                'type'=>'inline', // list
                'name'=>'spasfice_permissions['.$key.']',
                'options'=>$permission,
                'selected'=>$selected,
            ],
        ];
        $count++;
    }

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
        'note'=>[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>4],
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

    $fields['left_2']=[
        'fields_action'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'reports_permissions',
            'options'=>$reports_option,
            'selected'=>$report_permissions_selected,
        ],
    ];

    $fields['left_3']=[
        'fields_action'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'notifications_permissions',
            'options'=>$notification_option,
            'selected'=>$notification_permissions_selected,
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
    $fields['button_save'] = checkAdminPermission($permissions,'Roles','specific');
    $fields['button_save_edit'] = checkAdminPermission($permissions,'Roles','specific');
    $fields['send_mail'] = false;
    $fields['button_clear'] = false;
    $fields['custom_buttons'] = false;

    return $fields;
}
function form_attributes($fields,$id='')
{
    $permissions=getPermissions();
    if($id==''){
        $fields["action"] = route("roles.store");
    }else{
        $fields["action"] = route("roles.update",$id);
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = count($permissions)+count(config('var.spasfic_permissions'));
    $fields['left_count'] = 3;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $permissions=getPermissions();
    $count=1;
    foreach($permissions as $key=>$permission){
        $fields['title_right_'.$count]=$permission['module_name'].' Permissions';
        $fields['icon_right_'.$count]='icon-settings';
        $fields['col_right_'.$count]='col-md-6';
        $fields['input_check_right_'.$count]='permissions['.$key.'][]';
        $count++;
    }

    $spasfic_permissions=config('var.spasfic_permissions');
    foreach($spasfic_permissions as $key=>$permission){
        $fields['title_right_'.$count]=$key.' Permissions';
        $fields['icon_right_'.$count]='icon-settings';
        $fields['col_right_'.$count]='col-md-6';
        $fields['input_check_right_'.$count]='spasfice_permissions['.$key.'][]';
        $count++;
    }

    $fields['title_left_1']='Roles CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

    $fields['title_left_2']='Reports Permissions';
    $fields['icon_left_2']='icon-settings ';

    $fields['title_left_3']='Notifications Permissions';
    $fields['icon_left_3']='icon-settings ';

    return $fields;
}

function form_options()
{
    $side=[
        'full'=>'Full',
        'left'=>'Left',
        'right'=>'Right',

    ];
    $icon=getIcons();

    $group=[];
    $DB_options = [];
    $DB_options['side']=$side;
    $DB_options['icon']=$icon;

    return $DB_options;
}
