<?php

use App\Repositories\Interfaces\builder_management\ModuleInterface;

function form($data = [])
{

    $req=[];
    $req['select']=['id','name'];
    $modules=app(ModuleInterface::class)->data($req);
    $modules_option=[];
    $modules_option=getOptions($modules_option,$modules,'name');


    // $tables=getDBTable();
    $fields = [];

    $fields['full_1']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'api_var',
            'title'=>'Quert String',
            'name'=>'prams_counters',
            'options'=>form_options(),
            'values'=>(array_key_exists('prams_counters',$data) && $data['prams_counters'])?json_decode($data['prams_counters'],true):[],
        ],
    ];





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
    return $fields;
}
function form_attributes($fields,$id='')
{
    if($id==''){
        $fields["action"] = route("api.store");
    }else{
        $fields["action"] = route("api.update",$id);
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 0;
    $fields['left_count'] = 0;
    $fields['full_count'] = 1;
    $fields['left_corner'] = false;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_full_1']='Variables';
    $fields['icon_full_1']='icon-settings ';

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
