<?php
function form($data=[]){

    $fields=[];
    // Facebook
    $fields['right_1']=[
        'sochiel_login_facebook_client_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Id',
            'name'=>'sochiel_login_facebook_client_id',
            'placeholder'=>'Client Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_facebook_client_id',$data))?$data['sochiel_login_facebook_client_id']:''
        ],
        'sochiel_login_facebook_client_secret'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Sectet',
            'name'=>'sochiel_login_facebook_client_secret',
            'placeholder'=>'Client Sectet',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_facebook_client_secret',$data))?$data['sochiel_login_facebook_client_secret']:''
        ],
        'sochiel_login_facebook_redirect'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Redirect Url',
            'name'=>'sochiel_login_facebook_redirect',
            'placeholder'=>'Redirect Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-12',
            'value'=>(array_key_exists('sochiel_login_facebook_redirect',$data))?$data['sochiel_login_facebook_redirect']:''
        ],


    ];
    // Google
    $fields['right_2']=[
        'sochiel_login_google_client_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Id',
            'name'=>'sochiel_login_google_client_id',
            'placeholder'=>'Client Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_google_client_id',$data))?$data['sochiel_login_google_client_id']:''
        ],
        'sochiel_login_google_client_secret'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Sectet',
            'name'=>'sochiel_login_google_client_secret',
            'placeholder'=>'Client Sectet',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_google_client_secret',$data))?$data['sochiel_login_google_client_secret']:''
        ],
        'sochiel_login_google_redirect'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Redirect Url',
            'name'=>'sochiel_login_google_redirect',
            'placeholder'=>'Redirect Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-12',
            'value'=>(array_key_exists('sochiel_login_google_redirect',$data))?$data['sochiel_login_google_redirect']:''
        ],


    ];
    // LinkedIn
    $fields['right_3']=[
        'sochiel_login_linkedin_client_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Id',
            'name'=>'sochiel_login_linkedin_client_id',
            'placeholder'=>'Client Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_linkedin_client_id',$data))?$data['sochiel_login_linkedin_client_id']:''
        ],
        'sochiel_login_linkedin_client_secret'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Sectet',
            'name'=>'sochiel_login_linkedin_client_secret',
            'placeholder'=>'Client Sectet',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_linkedin_client_secret',$data))?$data['sochiel_login_linkedin_client_secret']:''
        ],
        'sochiel_login_linkedin_redirect'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Redirect Url',
            'name'=>'sochiel_login_linkedin_redirect',
            'placeholder'=>'Redirect Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-12',
            'value'=>(array_key_exists('sochiel_login_linkedin_redirect',$data))?$data['sochiel_login_linkedin_redirect']:''
        ],


    ];
    // Twitter
    $fields['right_4']=[
        'sochiel_login_twitter_client_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Id',
            'name'=>'sochiel_login_twitter_client_id',
            'placeholder'=>'Client Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_twitter_client_id',$data))?$data['sochiel_login_twitter_client_id']:''
        ],
        'sochiel_login_twitter_client_secret'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Sectet',
            'name'=>'sochiel_login_twitter_client_secret',
            'placeholder'=>'Client Sectet',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('sochiel_login_twitter_client_secret',$data))?$data['sochiel_login_twitter_client_secret']:''
        ],
        'sochiel_login_twitter_redirect'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Redirect Url',
            'name'=>'sochiel_login_twitter_redirect',
            'placeholder'=>'Redirect Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-12',
            'value'=>(array_key_exists('sochiel_login_twitter_redirect',$data))?$data['sochiel_login_twitter_redirect']:''
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
    $fields['right_count']=4;
    $fields['left_count']=0;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='Facebook Login';
    $fields['icon_right_1']='icon-settings';

    $fields['title_right_2']='Google Login';
    $fields['icon_right_2']='icon-settings';

    $fields['title_right_3']='LinkedIn Login';
    $fields['icon_right_3']='icon-settings';

    $fields['title_right_4']='Twitter Login';
    $fields['icon_right_4']='icon-settings';

    return $fields;
}

function form_options(){
    $DB_options=[];


    return $DB_options;
}
