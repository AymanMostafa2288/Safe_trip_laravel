<?php

use App\Repositories\Interfaces\builder_management\ModuleInterface;

function form($data = [])
{
    $tables=getDBTable();
    $req=[];
    $req['select']=['id','name'];
    $modules=app(ModuleInterface::class)->data($req);
    $modules_option=[];
    $modules_option=getOptions($modules_option,$modules,'name');
    $module_permissions_selected=[];
    if(!empty($data)){
        $module_permissions_selected=selectedOption('permission_id','install_permission_moduels','module_id',$data['id']);
    }
    $fields = [];
    $fields['right_1']=[
        'show_in_left_side'=>[
            'input_type'=>'select',
            'title'=>'Show In Left Side ?',
            'name'=>'show_in_left_side',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'options'=>[
                1=>'Yes',
                0=>'No',
            ],
            'selected'=>(array_key_exists('show_in_left_side',$data))?$data['show_in_left_side']:1
        ],
        'with_group'=>[
            'input_type'=>'select',
            'title'=>'With Group ?',
            'name'=>'with_group',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'options'=>getDepartments(),
            'selected'=>(array_key_exists('with_group',$data))?$data['with_group']:''
        ],
    ];
    $fields['right_2']=[
        'name_repo'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Repository Name',
            'name'=>'name_repo',
            'placeholder'=>'Repository Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('name_repo',$data))?$data['name_repo']:old('name_repo')
        ],
        'folder_repo'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Repository Folder',
            'name'=>'folder_repo',
            'placeholder'=>'Repository Folder',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('folder_repo',$data))?$data['folder_repo']:old('folder_repo')
        ],
        'model_repo'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Repository Model',
            'name'=>'model_repo',
            'placeholder'=>'Repository Model',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('model_repo',$data))?$data['model_repo']:old('model_repo')
        ],
        'route_repo'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Repository Route',
            'name'=>'route_repo',
            'placeholder'=>'Repository Route',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('route_repo',$data))?$data['route_repo']:old('route_repo')
        ],
        'controller_repo'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Repository Controller',
            'name'=>'controller_repo',
            'placeholder'=>'Repository Controller',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('controller_repo',$data))?$data['controller_repo']:old('controller_repo')
        ],
    ];
    $fields['right_3']=[
        'departments_module'=>[
            'input_type'=>'multi_record',
            'type'=>'departments_module',
            'title'=>'Departments',
            'name'=>'departments_module',
            'options'=>form_options(),
            'values'=>(array_key_exists('departments_module',$data))?json_decode($data['departments_module'],true):[],
        ],
    ];

    $fields['left_3']=[
        'module_permissions'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'module_permissions',
            'options'=>selectedOption('name','install_permissions','','',),
            'selected'=>$module_permissions_selected
        ],
    ];
    $fields['left_2']=[
        'fields_action'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'fields_action',
            'options'=>[
                1=>'Insert',
                2=>'Update',
                3=>'Delete',
                4=>'SEO Content',
                5=>'In SiteMap',
                6=>'Import Excel',
                7=>'Export Excel',
                8=>'Export Pdf',

            ],
            'selected'=>(array_key_exists('fields_action',$data) && $data['fields_action']!=null)?json_decode($data['fields_action'],true):[]
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
        'table_db'=>[
            'input_type'=>'select',
            'title'=>'DataBase Table',
            'name'=>'table_db',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$tables,
            'selected'=>(array_key_exists('table_db',$data))?$data['table_db']:1
        ],
        'crud_with'=>[
            'input_type'=>'select',
            'title'=>'Crud With',
            'name'=>'crud_with',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>array_merge([],$modules_option),
            'selected'=>(array_key_exists('crud_with',$data))?$data['crud_with']:1
        ],
    ];
    $fields['form_edit']=false;
    if(!empty($data)){
        $fields['form_edit']=true;
        $fields['link_create_repository']=url('dashboard/builder/modules/repository').'?name='.$data['name_repo'].'&folder='.$data['folder_repo'].'&model='.$data['model_repo'].'&route='.$data['route_repo'].'&controller='.$data['controller_repo'].'&module_id='.$data['id'];
        $fields['link_delete_repository']=url('dashboard/builder/modules/repository_delete').'?name='.$data['name_repo'].'&folder='.$data['folder_repo'].'&model='.$data['model_repo'].'&route='.$data['route_repo'].'&controller='.$data['controller_repo'].'&module_id='.$data['id'];
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
    if($fields['form_edit']){
        $fields['custom_buttons'] =true;
        $fields['custom_buttons_tags']=[
            [
                'type'=>'link',
                'href'=>$fields['link_create_repository'],
                'name'=>'Create Repository',
                'color'=>'green',
            ],
            [
                'type'=>'link',
                'href'=>$fields['link_delete_repository'],
                'name'=>'Delete Repository',
                'color'=>'red',
            ]
        ];
    }else{
        $fields['custom_buttons'] = false;
    }

    return $fields;
}
function form_attributes($fields,$id='')
{
    if($id==''){
        $fields["action"] = route("modules.store");
    }else{
        $fields["action"] = route("modules.update",$id);
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 3;
    $fields['left_count'] = 3;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_right_1']='Modules Admin Theme CONFIGURATIONS';
    $fields['icon_right_1']='icon-settings ';
    $fields['title_right_2']='Module Repository Configurations';
    $fields['icon_right_2']='icon-settings';
    $fields['title_right_3']='Module Departments Configurations';
    $fields['icon_right_3']='icon-settings';
    $fields['title_left_3']='Modules Permissions CONFIGURATIONS';
    $fields['icon_left_3']='icon-settings ';
    $fields['title_left_2']='Modules Operations CONFIGURATIONS';
    $fields['icon_left_2']='icon-settings ';
    $fields['title_left_1']='Modules CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

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
