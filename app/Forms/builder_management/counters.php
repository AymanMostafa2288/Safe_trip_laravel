<?php

use App\Repositories\Interfaces\builder_management\CounterInterface;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\builder_management\ReportInterface;

function form($data = [])
{

    $req=[];
    $req['select']=['id','name'];
    $modules=app(ModuleInterface::class)->data($req);
    $modules_option=[];
    $modules_option=getOptions($modules_option,$modules,'name');

    $req=[];
    $req['select']=['id','title'];
    $reports=app(ReportInterface::class)->data($req);
    $reports_option=[];
    $reports_option=getOptions($reports_option,$reports,'name');

    $module_permissions_selected=[];
    // $report_permissions_selected=[];
    // if(!empty($data)){
    //     $module_permissions_selected=selectedOption('module_id',$data['id'],'permission_id','install_permission_moduels');
    // }

    // $tables=getDBTable();
    $fields = [];
    $fields['right_1']=[
        'statement'=>[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>8],
            'title'=>'Statement',
            'name'=>'statement',
            'placeholder'=>'Statement',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'<p style="color:red">Statement should started by "Select count(*) as counter ...."</p>',
            'value'=>(array_key_exists('name',$data))?$data['statement']:''
        ],
    ];
    $fields['right_2']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'prams_counters',
            'title'=>'Prams',
            'name'=>'prams_counters',
            'options'=>form_options(),
            'values'=>(array_key_exists('prams_counters',$data))?json_decode($data['prams_counters'],true):[],
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
        'report_related'=>[
            'input_type'=>'select',
            'title'=>'Module Related',
            'name'=>'report_related',
            'placeholder'=>'Select Report',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$reports_option,
            'selected'=>(array_key_exists('report_related',$data))?$data['report_related']:''
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
                'card'=>'Card',
                'pie'=>'Pie',
            ],
            'selected'=>(array_key_exists('type',$data))?$data['type']:''
        ],
        'color'=>[
            'input_type'=>'select',
            'title'=>'Color',
            'name'=>'color',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[],
            'selected'=>(array_key_exists('color',$data))?$data['color']:1
        ],
        'icon'=>[
            'input_type'=>'select',
            'title'=>'Icon',
            'name'=>'icon',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>getIcons(),
            'selected'=>(array_key_exists('icon',$data))?$data['icon']:1
        ],
        'ordered'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Order',
            'name'=>'ordered',
            'placeholder'=>'Order',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('ordered',$data))?$data['ordered']:old('ordered')
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
        $fields["action"] = route("counters.store");
    }else{
        $fields["action"] = route("counters.update",$id);
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 2;
    $fields['left_count'] = 2;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_right_1']='SQL Statements';
    $fields['icon_right_1']='icon-settings ';

    $fields['title_right_2']='SQL Params';
    $fields['icon_right_2']='icon-settings';

    $fields['title_left_1']='Counter CONFIGURATIONS';
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
