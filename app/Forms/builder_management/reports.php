<?php
use App\Repositories\Interfaces\builder_management\ReportInterface;
function form($data = [])
{

    $tables=getDBTable();

    $req=[];
    $req['select']=['id','title'];
    $reports=app(ReportInterface::class)->data($req);
    $reports_option=[];
    $reports_option=getOptions($reports_option,$reports,'name');
    $fields = [];


    $fields['right_1']=[
        'report_joins'=>[
            'input_type'=>'multi_record',
            'type'=>'report_joins',
            'title'=>'Joins',
            'name'=>'db_joins',
            'options'=>form_options(),
            'values'=>(array_key_exists('db_joins',$data))?json_decode($data['db_joins'],true):[],
        ],
    ];
    $fields['right_2']=[
        'report_condtions'=>[
            'input_type'=>'multi_record',
            'type'=>'report_condtions',
            'title'=>'Condtions',
            'name'=>'db_condtions',
            'options'=>form_options(),
            'values'=>(array_key_exists('db_condtions',$data))?json_decode($data['db_condtions'],true):[],
        ],
    ];
    $fields['right_3']=[
        'report_select'=>[
            'input_type'=>'multi_record',
            'type'=>'report_select',
            'title'=>'Select',
            'name'=>'db_select',
            'options'=>form_options(),
            'values'=>(array_key_exists('db_select',$data))?json_decode($data['db_select'],true):[],
        ],
    ];
    $fields['right_4']=[
        'report_addtinal_filter'=>[
            'input_type'=>'multi_record',
            'type'=>'report_addtinal_filter',
            'title'=>'Addtinal Filter',
            'name'=>'report_addtinal_filter',
            'options'=>form_options(),
            'values'=>(array_key_exists('report_addtinal_filter',$data))?json_decode($data['report_addtinal_filter'],true):[],
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
            'value'=>(array_key_exists('name',$data))?$data['name']:old('name')
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
        'table_db'=>[
            'input_type'=>'select',
            'title'=>'DataBase Table',
            'name'=>'table_db',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$tables,
            'selected'=>(array_key_exists('table_db',$data))?$data['table_db']:1
        ],
        'show_in'=>[
            'input_type'=>'select',
            'title'=>'Show In ?',
            'name'=>'show_in',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'left_side'=>'Left Side',
                'home_page'=>'Home Page',
                'in_module'=>'In Module',
                'with_report'=>'With Report',
            ],
            'selected'=>(array_key_exists('show_in',$data))?$data['show_in']:1
        ],
        'text_align'=>[
            'input_type'=>'select',
            'title'=>'Text Align',
            'name'=>'text_align',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'left'=>'Left',
                'right'=>'Right',
                'full'=>'Full',
            ],
            'selected'=>(array_key_exists('text_align',$data))?$data['text_align']:1
        ],
        'module'=>[
            'input_type'=>'select',
            'title'=>'Module',
            'name'=>'module',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[],
            'selected'=>(array_key_exists('module',$data))?$data['module']:1
        ],
        'report'=>[
            'input_type'=>'select',
            'title'=>'Report',
            'name'=>'with_report',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>$reports_option,
            'selected'=>(array_key_exists('with_report',$data))?$data['with_report']:1
        ],
        'with_group'=>[
            'input_type'=>'select',
            'title'=>'With Group ?',
            'name'=>'with_group',
            'placeholder'=>'',
            'class'=>'select2_category',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>getDepartments(),
            'selected'=>(array_key_exists('with_group',$data))?$data['with_group']:''
        ],
    ];
    $fields['left_2']=[
        'group_by'=>[
            'input_type'=>'input',
            'type'=>'text',
            'title'=>'Group By',
            'name'=>'group_by',
            'placeholder'=>'Group By',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'value'=>(array_key_exists('group_by',$data))?$data['group_by']:old('group_by')
        ],
        'limit'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Limit',
            'name'=>'limit',
            'placeholder'=>'Limit',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'value'=>(array_key_exists('limit',$data))?$data['limit']:old('limit')
        ],

    ];
    $fields['left_3']=[
        'report_select'=>[
            'input_type'=>'multi_record',
            'type'=>'report_order_by',
            'title'=>'Order By',
            'name'=>'report_order_by',
            'options'=>form_options(),
            'values'=>(array_key_exists('report_order_by',$data))?json_decode($data['report_order_by'],true):[],
        ],
    ];

    $fields['left_4']=[
        'export_as'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'export_as',
            'options'=>[
                1=>'Export Excel',
                2=>'Export Pdf',

            ],
            'selected'=>(array_key_exists('export_as',$data))?json_decode($data['export_as'],true):[]
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
        $fields["action"] = route("reports.store");
    }else{
        $fields["action"] = route("reports.update",$id);
    }
    $fields['method'] = 'POST';
    $fields['class'] = '';
    $fields['id'] = $id;
    $fields['right_count'] = 4;
    $fields['left_count'] = 4;
    $fields['left_corner'] = true;
    $fields['show_button'] = true;
    return $fields;
}
function form_design($fields)
{
    $fields['title_right_1']='Report Joins';
    $fields['icon_right_1']='icon-settings';
    $fields['title_right_2']='Report Condtions';
    $fields['icon_right_2']='icon-settings';
    $fields['title_right_3']='Report Select';
    $fields['icon_right_3']='icon-settings';
    $fields['title_right_4']='Report Addtional Filter';
    $fields['icon_right_4']='icon-settings';

    $fields['title_left_1']='Report Information';
    $fields['icon_left_1']='icon-settings ';
    $fields['title_left_2']='Report CONFIGURATIONS';
    $fields['icon_left_2']='icon-settings ';
    $fields['title_left_3']='Report Order By';
    $fields['icon_left_3']='icon-settings ';
    $fields['title_left_4']='Report Export';
    $fields['icon_left_4']='icon-settings ';

    return $fields;
}

function form_options()
{
    $options=[
        'text'=>'Text',
        'number'=>'Number',
        'date'=>'DATE',
        'select'=>'Select',
    ];
    $true=[
        'no'=>'No',
        'yes'=>'Yes'
    ];
    $tables=getDBTable();

    $group=[];
    $DB_options = [];
    $DB_options['options']=$options;
    $DB_options['true']=$true;
    $DB_options['db_tables']=$tables;
    $DB_options['group']=$group;

    return $DB_options;
}
