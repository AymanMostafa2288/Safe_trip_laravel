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
    $fields['right_1']=[
        "labels" => [
            "input_type" => "input",
            "type" => "hidden",
            "title" => "Labels",
            "name" => "labels",
            "placeholder" => "Labels",
            "class" => "select2_sample3",
            "around_div" => "form-group form-md-line-input",

            "value" => (array_key_exists("labels", $data)) ? $data["labels"] : old("labels"),
        ],
    ];
    $fields['right_2']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'datasate_config',
            'title'=>'Datasate Configrations',
            'name'=>'datasate_config',
            'options'=>form_options(),
            'values'=>(array_key_exists('datasate_config',$data))?json_decode($data['datasate_config'],true):[],
        ],
    ];
    $fields['right_3']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'sql_statments',
            'title'=>'SQL Statments',
            'name'=>'sql_statments',
            'options'=>form_options(),
            'values'=>(array_key_exists('sql_statments',$data))?json_decode($data['sql_statments'],true):[],
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
    ];
    $fields['left_2']=[
        'module_related'=>[
            'input_type'=>'select',
            'title'=>'Module Related',
            'name'=>'module_related',
            'placeholder'=>'Select Module',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$modules_option,
            'selected'=>(array_key_exists('module_related',$data))?$data['module_related']:''
        ],
        'type'=>[
            'input_type'=>'select',
            'title'=>'Type',
            'name'=>'type',
            'placeholder'=>'Select Type',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'bar'=>'Bar',
                'line'=>'Line',
                'pie'=>'Pie',
            ],
            'selected'=>(array_key_exists('type',$data))?$data['type']:''
        ],
        'width'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Width',
            'name'=>'width',
            'placeholder'=>'Width',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('width',$data))?$data['width']:old('width')
        ],
        'hight'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Height',
            'name'=>'height',
            'placeholder'=>'Height',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('height',$data))?$data['height']:old('height')
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
        $fields["action"] = route("charts.store");
    }else{
        $fields["action"] = route("charts.update",$id);
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
    $fields['title_right_1']='Labels';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_right_2']='Datasate Config';
    $fields['icon_right_2']='icon-settings';

    $fields['title_right_3']='SQL Statments';
    $fields['icon_right_3']='icon-settings';

    $fields['title_left_1']='Chart CONFIGURATIONS';
    $fields['icon_left_1']='icon-settings ';

    $fields['title_left_2']='Card CONFIGURATIONS';
    $fields['icon_left_2']='icon-settings ';

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
