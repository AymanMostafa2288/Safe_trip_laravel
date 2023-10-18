<?php


function form($data=[]){

    $fields=[];
    // PAYMOB
    $fields['right_1']=[
        'paymob_api_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Api Key',
            'name'=>'paymob_api_key',
            'placeholder'=>'API Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paymob_api_key',$data))?$data['paymob_api_key']:''
        ],
        'paymob_integration_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Integration Id',
            'name'=>'paymob_integration_id',
            'placeholder'=>'Integration Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paymob_integration_id',$data))?$data['paymob_integration_id']:''
        ],
        'paymob_iframe_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Iframe Id',
            'name'=>'paymob_iframe_id',
            'placeholder'=>'Iframe Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paymob_iframe_id',$data))?$data['paymob_iframe_id']:''
        ],
        'paymob_hmac'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'HMAC',
            'name'=>'paymob_hmac',
            'placeholder'=>'HMAC',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paymob_hmac',$data))?$data['paymob_hmac']:''
        ],
        'paymob_currency'=>[
            'input_type'=>'select',
            'title'=>'Currency',
            'name'=>'paymob_currency',
            'placeholder'=>'Select Currency',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EGP'=>'EGP',
                'SAR'=>'SAR',
                'USD'=>'USD'
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('paymob_currency',$data))?$data['paymob_currency']:''
        ],
    ];
    // HYPERPAY
    $fields['right_2']=[
        'hyperpay_base_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Base Url',
            'name'=>'hyperpay_base_url',
            'placeholder'=>'Base Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('hyperpay_base_url',$data))?$data['hyperpay_base_url']:'https://eu-test.oppwa.com'
        ],
        'hyperpay_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Url',
            'name'=>'hyperpay_url',
            'placeholder'=>'Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('hyperpay_url',$data))?$data['hyperpay_url']:'https://eu-test.oppwa.com/v1/checkouts'
        ],
        'hyperpay_token'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Token',
            'name'=>'hyperpay_token',
            'placeholder'=>'Token',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('hyperpay_token',$data))?$data['hyperpay_token']:''
        ],
        'hyperpay_cerdit_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Cerdit Id',
            'name'=>'hyperpay_cerdit_id',
            'placeholder'=>'Cerdit Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('hyperpay_cerdit_id',$data))?$data['hyperpay_cerdit_id']:''
        ],
        'hyperpay_mada_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Mada Id',
            'name'=>'hyperpay_mada_id',
            'placeholder'=>'Mada Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('hyperpay_mada_id',$data))?$data['hyperpay_mada_id']:''
        ],
        'hyperpay_apple_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Apple Id',
            'name'=>'hyperpay_apple_id',
            'placeholder'=>'Apple Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('hyperpay_apple_id',$data))?$data['hyperpay_apple_id']:''
        ],
        'hyperpay_currency'=>[
            'input_type'=>'select',
            'title'=>'Currency',
            'name'=>'hyperpay_currency',
            'placeholder'=>'Select Currency',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EGP'=>'EGP',
                'SAR'=>'SAR',
                'USD'=>'USD'
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('hyperpay_currency',$data))?$data['hyperpay_currency']:''
        ],
    ];
    // PAYPAL
    $fields['right_3']=[
        'paypal_client_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Client Id',
            'name'=>'paypal_client_id',
            'placeholder'=>'Client Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paypal_client_id',$data))?$data['paypal_client_id']:''
        ],
        'paypal_secret_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Secret Key',
            'name'=>'paypal_secret_key',
            'placeholder'=>'Secret Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paypal_secret_key',$data))?$data['paypal_secret_key']:''
        ],
        'paypal_currency'=>[
            'input_type'=>'select',
            'title'=>'Currency',
            'name'=>'paypal_currency',
            'placeholder'=>'Select Currency',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EGP'=>'EGP',
                'SAR'=>'SAR',
                'USD'=>'USD'
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('paypal_currency',$data))?$data['paypal_currency']:''
        ],
        'paypal_mood'=>[
            'input_type'=>'select',
            'title'=>'Mood',
            'name'=>'paypal_mood',
            'placeholder'=>'Select Mood',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'sandbox'=>'Test',
                'live'=>'Live',
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('paypal_mood',$data))?$data['paypal_mood']:''
        ],
    ];
    //OPAY
    $fields['right_4']=[
        'opay_secret_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Secret Key',
            'name'=>'opay_base_url',
            'placeholder'=>'Secret Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('opay_secret_key',$data))?$data['opay_secret_key']:''
        ],
        'opay_public_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Public Key',
            'name'=>'opay_public_key',
            'placeholder'=>'Public Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('opay_public_key',$data))?$data['opay_public_key']:''
        ],
        'opay_merchant_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Merchant Id',
            'name'=>'opay_merchant_id',
            'placeholder'=>'Merchant Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('opay_merchant_id',$data))?$data['opay_merchant_id']:''
        ],
        'opay_base_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Base Url',
            'name'=>'opay_base_url',
            'placeholder'=>'Base Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'https://api.opaycheckout.com for production',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('opay_base_url',$data))?$data['opay_base_url']:'https://sandboxapi.opaycheckout.com'
        ],
        'opay_currency'=>[
            'input_type'=>'select',
            'title'=>'Currency',
            'name'=>'opay_currency',
            'placeholder'=>'Select Currency',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EGP'=>'EGP',
                'SAR'=>'SAR',
                'USD'=>'USD'
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('opay_currency',$data))?$data['opay_currency']:''
        ],
        'opay_country_code'=>[
            'input_type'=>'select',
            'title'=>'Country Code',
            'name'=>'opay_country_code',
            'placeholder'=>'Select Country Code',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EG'=>'Egypt',
                'SA'=>'Saudi Arabia',
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('opay_country_code',$data))?$data['opay_country_code']:''
        ],
    ];
    //KASHIER
    $fields['right_5']=[
        'kashier_account_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Account Key',
            'name'=>'kashier_account_key',
            'placeholder'=>'Account Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('kashier_account_key',$data))?$data['kashier_account_key']:''
        ],
        'kashier_iframe_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Iframe Key',
            'name'=>'kashier_iframe_key',
            'placeholder'=>'Iframe Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('kashier_iframe_key',$data))?$data['kashier_iframe_key']:''
        ],
        'kashier_token'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Token',
            'name'=>'kashier_token',
            'placeholder'=>'Token',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('kashier_token',$data))?$data['kashier_token']:''
        ],
        'kashier_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Url',
            'name'=>'kashier_url',
            'placeholder'=>'Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('kashier_url',$data))?$data['kashier_url']:'https://checkout.kashier.io'
        ],

        'kashier_currency'=>[
            'input_type'=>'select',
            'title'=>'Currency',
            'name'=>'kashier_currency',
            'placeholder'=>'Select Currency',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EGP'=>'EGP',
                'SAR'=>'SAR',
                'USD'=>'USD'
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('kashier_currency',$data))?$data['kashier_currency']:''
        ],
        'kashier_mood'=>[
            'input_type'=>'select',
            'title'=>'Mood',
            'name'=>'kashier_mood',
            'placeholder'=>'Select Mood',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'test'=>'Test',
                'live'=>'Live',
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('kashier_mood',$data))?$data['kashier_mood']:''
        ],

    ];
    //PAYTAP
    $fields['right_6']=[
        'paytap_profile_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Profile Id',
            'name'=>'paytap_profile_id',
            'placeholder'=>'Profile Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paytap_profile_id',$data))?$data['paytap_profile_id']:''
        ],
        'paytap_server_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Server Key',
            'name'=>'paytap_server_key',
            'placeholder'=>'Server Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paytap_server_key',$data))?$data['paytap_server_key']:''
        ],
        'paytap_base_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Base Url',
            'name'=>'paytap_base_url',
            'placeholder'=>'Base URL',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'col'=>'col-md-6',
            'value'=>(array_key_exists('paytap_base_url',$data))?$data['paytap_base_url']:'https://secure-egypt.paytabs.com'
        ],
        'paytap_currency'=>[
            'input_type'=>'select',
            'title'=>'Currency',
            'name'=>'paytap_currency',
            'placeholder'=>'Select Currency',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'EGP'=>'EGP',
                'SAR'=>'SAR',
                'USD'=>'USD'
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('paytap_currency',$data))?$data['paytap_currency']:''
        ],
        'paytap_language'=>[
            'input_type'=>'select',
            'title'=>'Language',
            'name'=>'paytap_language',
            'placeholder'=>'Select Language',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'AR'=>'Arabic',
                'EN'=>'English',
            ],
            'col'=>'col-md-6',
            'selected'=>(array_key_exists('paytap_language',$data))?$data['paytap_language']:''
        ],

    ];





    // FAWRY
    $fields['left_1']=[
        'fawry_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Url',
            'name'=>'fawry_url',
            'placeholder'=>'Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('fawry_url',$data))?$data['fawry_url']:''
        ],
        'fawry_secret'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Sectet Key',
            'name'=>'fawry_secret',
            'placeholder'=>'Sectet Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('fawry_secret',$data))?$data['fawry_secret']:''
        ],
        'fawry_merchant'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Merchant Key',
            'name'=>'fawry_merchant',
            'placeholder'=>'Merchant Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('fawry_merchant',$data))?$data['fawry_merchant']:''
        ],
    ];

    // THAWANI
    $fields['left_2']=[
        'thawani_url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Url',
            'name'=>'thawani_url',
            'placeholder'=>'Url',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('thawani_url',$data))?$data['thawani_url']:''
        ],
        'thawani_api_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Api Key',
            'name'=>'thawani_api_key',
            'placeholder'=>'Api Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('thawani_api_key',$data))?$data['thawani_api_key']:''
        ],
        'thawani_publishable_key'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Publishable Key',
            'name'=>'thawani_publishable_key',
            'placeholder'=>'Publishable Key',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('thawani_publishable_key',$data))?$data['thawani_publishable_key']:''
        ],
    ];

    //PAYMOB_WALLET (vodaphone-cash,orange-money,etisalat-cash,we-cash,meza-wallet)
    $fields['left_3']=[
        'paymob_wallet_integration_id'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Integration Id',
            'name'=>'paymob_wallet_integration_id',
            'placeholder'=>'Integration Id',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('paymob_wallet_integration_id',$data))?$data['paymob_wallet_integration_id']:''
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
    $fields["custom_buttons_tags"]=[


    ];
    return $fields;
}
function form_attributes($fields){
    $fields['action']=route('generals.store');
    $fields['method']='POST';
    $fields['class']='';
    $fields['id']='';
    $fields['right_count']=6;
    $fields['left_count']=3;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='Paymob Configration';
    $fields['icon_right_1']='icon-settings';

    $fields['title_right_2']='Hyperpay Configration';
    $fields['icon_right_2']='icon-settings';

    $fields['title_right_3']='Paypal Configration';
    $fields['icon_right_3']='icon-settings';

    $fields['title_right_4']='Opay Configration';
    $fields['icon_right_4']='icon-settings';

    $fields['title_right_5']='Kashier Configration';
    $fields['icon_right_5']='icon-settings';

    $fields['title_right_6']='Paytap Configration';
    $fields['icon_right_6']='icon-settings';

    $fields['title_left_1']='Fawry Configration';
    $fields['icon_left_1']='icon-settings ';

    $fields['title_left_2']='Thawani Configration';
    $fields['icon_left_2']='icon-settings ';

    $fields['title_left_3']='Paymob Wallet Configration';
    $fields['icon_left_3']='icon-settings ';



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
