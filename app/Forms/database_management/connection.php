<?php


function form($data=[]){

    $fields=[];
    $fields['right_1']=[
        'DB_CONNECTION'=>[
            'input_type'=>'select',
            'title'=>'DataBase Connection',
            'name'=>'DB_CONNECTION',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'mysql'=>'MySql',
                'sql'=>'Sql Server',
                'oracle'=>'Oracle',
            ],
            'selected'=>old('DB_CONNECTION',env('DB_CONNECTION'))
        ],
        'DB_HOST'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'DataBase Host',
            'name'=>'DB_HOST',
            'placeholder'=>'DataBase Host',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('DB_HOST',env('DB_HOST'))
        ],
        'DB_PORT'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'DataBase Port',
            'name'=>'DB_PORT',
            'placeholder'=>'DataBase Port',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('DB_PORT',env('DB_PORT'))
        ],

    ];
    $fields['right_2']=[
        'DB_DATABASE'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'DataBase Name',
            'name'=>'DB_DATABASE',
            'placeholder'=>'DataBase Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('DB_DATABASE',env('DB_DATABASE'))
        ],
        'DB_USERNAME'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'DataBase User',
            'name'=>'DB_USERNAME',
            'placeholder'=>'DataBase User',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('DB_USERNAME',env('DB_USERNAME'))
        ],
        'DB_PASSWORD'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'DataBase Password',
            'name'=>'DB_PASSWORD',
            'placeholder'=>'DataBase Password',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('DB_PASSWORD',env('DB_PASSWORD'))
        ],
        'DB_SUFFIX'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'DataBase Suffix',
            'name'=>'DB_SUFFIX',
            'placeholder'=>'DataBase Suffix',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('DB_SUFFIX',env('DB_SUFFIX'))
        ],
    ];
    $fields['left_1']=[
        'APP_NAME'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'APP NAME',
            'name'=>'APP_NAME',
            'placeholder'=>'APP NAME',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('APP_NAME',env('APP_NAME'))
        ],
        'APP_URL'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'APP URl',
            'name'=>'APP_URL',
            'placeholder'=>'APP URl',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('APP_URL',env('APP_URL'))
        ],
    ];

    $fields['left_2']=[
        'Dashboard_Route'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Dashboard Route',
            'name'=>'Dashboard_Route',
            'placeholder'=>'Dashboard Route',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>old('Dashboard_Route',env('DASHBOARD_ROUTE'))
        ],
        'Dashboard_Theme'=>[
            'input_type'=>'select',
            'title'=>'Dashboard Theme',
            'name'=>'Dashboard_Theme',
            'placeholder'=>'',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'main'=>'Main',
            ],
            'selected'=>old('Dashboard_Theme',env('DASHBOARD_THEME'))
        ],
    ];

    $fields=form_buttons($fields);
    $fields=form_attributes($fields);
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
function form_attributes($fields){
    $fields['action']=route('connect_database.post');
    $fields['method']='POST';
    $fields['class']='';
    $fields['id']='';
    $fields['right_count']=2;
    $fields['left_count']=2;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='MAIN Server Connection';
    $fields['icon_right_1']='icon-settings';
    $fields['title_right_2']='MAIN Database Connection';
    $fields['icon_right_2']='icon-settings';
    $fields['title_left_1']='App Configurations';
    $fields['icon_left_1']='icon-settings ';
    $fields['title_left_2']='Dashboard Configurations';
    $fields['icon_left_2']='icon-settings ';
    return $fields;
}
