<?php


function form($data=[]){
    $fields=[];
    $fields['right_1']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'fields',
            'title'=>'Fields',
            'name'=>'fields_record',
            'options'=>form_options(),
            'values'=>(array_key_exists('value',$data))?$data['value']['fields_record']:[],
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
        'storage_engine'=>[
            'input_type'=>'select',
            'title'=>'Storage Engine',
            'name'=>'storage_engine',
            'placeholder'=>'Storage Engine',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'InnoDB'=>'InnoDB',
                'MyISAM'=>'MyISAM',
            ],
            'selected'=>(array_key_exists('value',$data))?$data['value']['storage_engine']:old('storage_engine')
        ],
        'with_table_translate'=>[
            'input_type'=>'select',
            'title'=>'With Table Translate',
            'name'=>'with_table_translate',
            'placeholder'=>'With Table Translate',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'yes'=>'Yes',
                'no'=>'No',
            ],
            'selected'=>(array_key_exists('value',$data) && array_key_exists('with_table_translate',$data['value']))?$data['value']['with_table_translate']:'yes'
        ],
    ];
    $fields['left_2']=[
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
            'value'=>(array_key_exists('value',$data) && array_key_exists('note',$data['value']))?$data['value']['note']:old('note')
        ],
    ];



    $fields=form_buttons($fields,$data);
    if(empty($data)){
        $fields = form_attributes($fields);
    }else{
        $fields = form_attributes($fields,$data['id']);
    }
    $fields=form_design($fields);
    return $fields;
}

function form_buttons($fields,$data){
    $fields['button_save']=true;
    $fields['button_save_edit']=false;
    $fields['send_mail']=false;
    $fields['button_clear']=false;

    if(!empty($data)){
        $fields['custom_buttons'] =true;
        $fields['custom_buttons_tags']=[
            [
                'type'=>'link',
                'href'=>route('tables.genrate-migration').'?table_name='.env('DB_SUFFIX').$data['name'],
                'name'=>'Create Migration',
                'color'=>'green',
            ],
        ];
    }else{
        $fields['custom_buttons'] = false;
    }

    return $fields;
}
function form_attributes($fields,$id=''){
    if($id==''){
        $fields["action"] = route("tables.store");
    }else{
        $fields["action"] = route("tables.update",$id);
    }


    $fields['method']='POST';
    $fields['class']='';
    $fields['id']=$id;
    $fields['right_count']=1;
    $fields['left_count']=2;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='Fields Configurations';
    $fields['icon_right_1']='icon-settings';
    $fields['title_left_1']='Table Configurations';
    $fields['icon_left_1']='icon-settings ';
    $fields['title_left_2']='Note';
    $fields['icon_left_2']='icon-settings ';
    return $fields;
}

function form_options(){
    $DB_options=[];
    $options=[
        'int'=>'INT',
        'foreign_id'=>'foreign_id',
        'varchar'=>'VARCHAR',
        'text'=>'TEXT',
        'date'=>'DATE',
        'big_int'=>'BIGINT',
        'decimal'=>'DECIMAL',
        'float'=>'FLOAT',
        'boolean'=>'BOOLEAN',
        'date_time'=>'DATETIME',
        'timestamp'=>'TIMESTAMP',
        'time'=>'TIME',
        'date'=>'DATE',
        'char'=>'CHAR',
        'medium_text'=>'MEDIUMTEXT',
        'long_text'=>'LONGTEXT',
        'enum'=>'ENUM',
    ];
    $default=[
        'none'=>'NONE',
        'as_defined'=>'As Defined',
        'null'=>'Null',
    ];
    $indexed=[
        'none'=>'none',
        'unique'=>'UNIQUE',
        'indexed'=>'INDEXED',
    ];
    $tables=getDBTable();

    $DB_options['options']=$options;
    $DB_options['default']=$default;
    $DB_options['indexed']=$indexed;
    $DB_options['tables']=$tables;
    return $DB_options;
}
