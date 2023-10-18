<?php

function form($data = [])
{
    $tables=getDBTable();

    $type_fields=[
        'text'=>'Text',
        'hidden'=>'Hidden',
        'number'=>'Number',
        'email'=>'Email',
        'password'=>'Password',
        'date'=>'DATE',
        'time'=>'time',
        'date_time'=>'Date Time',
        'checkbox'=>'Check Box',
        'radio_button'=>'Radio Button',
        'text_area'=>'Text Area',
        'text_editor'=>'Text Editor',
        'image'=>'Image',
        'multi_image'=>'Multi Image',
        'file'=>'File',
        'multi_file'=>'Multi File',
        'record'=>'Record',
        'video'=>'Video',
        'select'=>'Select',
        'select_search'=>'Select With Search',
        'multi_select'=>'Multi Select',
        'multi_select_search'=>'Multi Select With Search',
        'tags'=>'Tags',
        'maps'=>'Maps',
    ];
    $fields = [];
    $fields['right_1']=[
        'with_group'=>[
            'input_type'=>'select',
            'title'=>'With Group ?',
            'name'=>'with_group',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'options'=>(array_key_exists('module_id',$data))?geModuleDepartments($data['module_id']):geModuleDepartments($_GET['related_to']),
            'selected'=>(array_key_exists('with_group',$data))?$data['with_group']:''
        ],
        'around_div'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Around Div',
            'name'=>'around_div',
            'placeholder'=>'Around Div',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists('around_div',$data))?$data['around_div']:old('around_div')
        ],
        'hint'=>[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>4],
            'title'=>'Hint',
            'name'=>'hint',
            'placeholder'=>'Hint',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-12',
            'below_div'=>'',
            'value'=>(array_key_exists('hint',$data))?$data['hint']:''
        ],

    ];
    $fields['right_2']=[
        'fields_module'=>[
            'input_type'=>'multi_record',
            'type'=>'fields_module',
            'title'=>'Fields',
            'name'=>'fields_module',
            'options'=>form_options(),
            'values'=>(array_key_exists('fields_module',$data))?json_decode($data['fields_module'],true):[],
        ],

    ];

    $fields['left_3']=[
        'fields_action'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'fields_action',
            'options'=>[
                1=>'Editable',
                2=>'Unique',
                3=>'Required',
                4=>'In Table View',
                5=>'In Api',
                6=>'In Translations',
                7=>'Bluck Changes',

            ],
            'selected'=>(array_key_exists('fields_action',$data))?json_decode($data['fields_action'],true):[]
        ],

    ];
    $fields['left_2']=[
        'min'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Min',
            'name'=>'min',
            'placeholder'=>'Min',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('min',$data))?$data['min']:old('min')
        ],
        'max'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Max',
            'name'=>'max',
            'placeholder'=>'Max',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('max',$data))?$data['max']:old('max')
        ],
        'regex'=>[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>4],
            'title'=>'Regex',
            'name'=>'regex',
            'placeholder'=>'Regex',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('regex',$data))?$data['regex']:''
        ],

    ];
    $fields['left_1']=[
        'name'=>[
            'input_type'=>'select',
            'title'=>'Name',
            'name'=>'name',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>(array_key_exists('module_id',$data))?getDBFieldsTable($data['module_id']):getDBFieldsTable($_GET['related_to']),
            'selected'=>(array_key_exists('name',$data))?$data['name']:1
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
        'show_as'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Show As',
            'name'=>'show_as',
            'placeholder'=>'Show As',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('show_as',$data))?$data['show_as']:old('show_as')
        ],
        'type'=>[
            'input_type'=>'select',
            'title'=>'Type',
            'name'=>'type',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$type_fields,
            'selected'=>(array_key_exists('type',$data))?$data['type']:1
        ],
        'related_with'=>[
            'input_type'=>'select',
            'title'=>'Related With',
            'name'=>'related_with',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>getDBTable(),
            'selected'=>(array_key_exists('related_with',$data))?$data['related_with']:1
        ],
    ];
    if(array_key_exists('related_to',$_GET)){
        $fields['left_1']['module_id']=[
            'input_type'=>'input',
            'type'=>'hidden',
            'title'=>'',
            'name'=>'module_id',
            'placeholder'=>'Module ID',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('module_id',$data))?$data['module_id']:$_GET['related_to']
        ];
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
    $fields['translate'] = false;
    return $fields;
}
function form_attributes($fields,$id='')
{
    if($id==''){
        $fields["action"] = route("module_fields.store");
    }else{
        $fields["action"] = route("module_fields.update",$id);
    }
    $fields["translate_href"] = url("dashboard/builder/module_fields/translate/".$id);
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 2;
    $fields['left_count'] = 3;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_right_1']='Field View CONFIGURATIONS';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_right_2']='Field Values Configurations';
    $fields['icon_right_2']='icon-settings';

    $fields['title_left_3']='Field Operations CONFIGURATIONS';
    $fields['icon_left_3']='icon-settings ';

    $fields['title_left_2']='Field Validations CONFIGURATIONS';
    $fields['icon_left_2']='icon-settings ';

    $fields['title_left_1']='Field CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options()
{
    $DB_options = [];

    return $DB_options;
}
