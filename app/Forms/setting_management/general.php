<?php


function form($data=[]){

    $fields=[];
    $fields['right_1']=[
        'App_LOGO'=>[
            'input_type'=>'upload_image',
            'title'=>'Logo',
            'name'=>'app_logo',
            'placeholder'=>'',
            'class'=>'select2_category',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('app_logo',$data))?readFileStorage($data['app_logo']):''
        ],

        'White_Logo'=>[
            'input_type'=>'upload_image',
            'title'=>'White Logo',
            'name'=>'white_logo',
            'placeholder'=>'',
            'class'=>'select2_category',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('white_logo',$data))?readFileStorage($data['white_logo']):''
        ],
        'App_Favicon'=>[
            'input_type'=>'upload_image',
            'title'=>'Favicon',
            'name'=>'app_favicon',
            'placeholder'=>'',
            'class'=>'select2_category',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('app_favicon',$data))?readFileStorage($data['app_favicon']):''
        ],

    ];

    $fields['left_1']=[
        'app_name'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'App Name',
            'name'=>'app_name',
            'placeholder'=>'App Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('app_name',$data))?$data['app_name']:''
        ],
        'Email'=>[
            'input_type'=>'input',
            'type'=>'email',
            'title'=>'Email',
            'name'=>'email',
            'placeholder'=>'Email',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('email',$data))?$data['email']:''
        ],
        'Telephone'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Telephone',
            'name'=>'telephone',
            'placeholder'=>'Telephone',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('telephone',$data))?$data['telephone']:''
        ],
        'Mobile'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Mobile',
            'name'=>'mobile',
            'placeholder'=>'Mobile',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('mobile',$data))?$data['mobile']:''
        ],
        'Fax'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Fax',
            'name'=>'fax',
            'placeholder'=>'Fax',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('fax',$data))?$data['fax']:''
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
    $fields["custom_buttons"] = false;
    $fields["custom_buttons_tags"]=[];
    return $fields;
}
function form_attributes($fields){
    $fields['action']=route('generals.store');
    $fields['method']='POST';
    $fields['class']='';
    $fields['id']='';
    $fields['right_count']=1;
    $fields['left_count']=1;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='App Logos';
    $fields['icon_right_1']='icon-settings';



    $fields['title_left_1']='App Setting';
    $fields['icon_left_1']='icon-settings ';

    return $fields;
}

function form_options(){
    $DB_options=[];
    $icon=getIcons();
    $parent=getDepartments();
    $DB_options['icon']=$icon;
    $DB_options['parent']=$parent;

    return $DB_options;
}
