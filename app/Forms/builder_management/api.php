<?php

use App\Repositories\Interfaces\builder_management\ModuleInterface;

function form($data = [])
{

    $req=[];
    $req['select']=['id','name'];
    $modules=app(ModuleInterface::class)->data($req);
    $modules_option=[];
    $modules_option=getOptions($modules_option,$modules,'name');

    $fields = [];
    $fields['right_1']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'query_string',
            'title'=>'Quert String',
            'name'=>'prams_counters',
            'options'=>form_options(),
            'values'=>(array_key_exists('prams_counters',$data) && $data['prams_counters'])?json_decode($data['prams_counters'],true):[],
        ],
    ];
    $fields['right_2']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'form_body',
            'title'=>'Form Body',
            'name'=>'form_body',
            'options'=>form_options(),
            'values'=>(array_key_exists('form_body',$data) && $data['form_body'])?json_decode($data['form_body'],true):[],
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
            'value'=>(array_key_exists('name',$data))?$data['name']:''
        ],
        'route_name'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Route Name',
            'name'=>'route_name',
            'placeholder'=>'Route Name',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('route_name',$data))?$data['route_name']:''
        ],
        'url'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'URL',
            'name'=>'url',
            'placeholder'=>'URL',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('route_name',$data))?route($data['route_name']):''
        ],
        'type'=>[
            'input_type'=>'select',
            'title'=>'Type',
            'name'=>'type',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'attributes'=>['show_div_by'=>'["get","post","delete","put"]',"div_depends_show"=>'["query_string_div","form_body_div","query_string_div","form_body_div"]'],
            'options'=>[
                'get'=>'GET',
                'post'=>'POST',
                'delete'=>'Delete',
                'put'=>'PUT',
            ],
            'selected'=>(array_key_exists('type',$data))?$data['type']:'get'
        ],
    ];

    $fields['left_2']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'form_header',
            'title'=>'Form Header',
            'name'=>'form_header',
            'options'=>form_options(),
            'values'=>(array_key_exists('form_header',$data) && $data['form_header'])?json_decode($data['form_header'],true):[],
        ],
    ];
    $fields['left_3']=[
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

    $fields['right_3']=[
        'result'=>[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>4],
            'title'=>'Result',
            'name'=>'result',
            'placeholder'=>'Result',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-12',
            'below_div'=>'',
            'attributes'=>[
                'rows'=>10,
                'readonly'=>'readonly',
            ],
            'value'=>(array_key_exists('result',$data))?$data['result']:''
        ],
    ];






    $fields = form_buttons($fields);
    $fields['form_edit']=false;
    if(empty($data)){
        $fields = form_attributes($fields);
    }else{
        $fields['form_edit']=true;
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
    return $fields;
}
function form_attributes($fields,$id='')
{
    if($id==''){
        $fields["action"] = route("api.store");
    }else{
        $fields["action"] = route("api.update",$id);
    }
    if($fields['form_edit']){
        $fields['custom_buttons'] =true;
        $fields['custom_buttons_tags']=[
            [
                'type'=>'link',
                'href'=>'#',
                'name'=>'Test Api',
                'color'=>'green',
            ],
        ];
    }else{
        $fields['custom_buttons'] = false;
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 3;
    $fields['left_count'] = 2;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_right_1']='Query String';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_right_2']='Form Body';
    $fields['icon_right_2']='icon-settings';


    $fields['title_right_3']='Results';
    $fields['icon_right_3']='icon-settings';

    $fields['title_left_1']='Informations';
    $fields['icon_left_1']='icon-settings ';

    $fields['title_left_2']='Form Header';
    $fields['icon_left_2']='icon-settings ';

    $fields['title_left_3']='Note';
    $fields['icon_left_3']='icon-settings ';

    return $fields;
}

function form_options()
{

    $DB_options = [];
    $fields_type=[
        'static'=>'Static',
        'get_param'=>'From Get Pram',
    ];
   $DB_options['fields_type']=$fields_type;
    return $DB_options;
}
