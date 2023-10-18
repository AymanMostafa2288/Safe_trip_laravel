<?php


function form($data=[]){

    $fields=[];
    $rights=[
        'workes_time'=>'Workes Time',
    ];
    foreach($rights as $key=>$value){
        $array[$key.'_'.'ar']=[
            'input_type'=>'input',
            "type" => "text",
            'title'=>$value.' (Arabic)',
            'name'=>$key.'_'.'ar',
            'placeholder'=>$value.' (Arabic)',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists($key.'_'.'ar',$data))?$data[$key.'_'.'ar']:''
        ];
        $array[$key.'_'.'en']=[
            'input_type'=>'input',
            "type" => "text",
            'title'=>$value.' (English)',
            'name'=>$key.'_'.'en',
            'placeholder'=>$value.' (English)',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists($key.'_'.'en',$data))?$data[$key.'_'.'en']:''
        ];
    }
    $fields['right_1']=$array;

    $rights=[];
    $array=[];
    foreach($rights as $key=>$value){
        $array[$key.'_'.'ar']=[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>8],
            'title'=>$value.' (Arabic)',
            'name'=>$key.'_'.'ar',
            'placeholder'=>$value.' (Arabic)',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists($key.'_'.'ar',$data))?$data[$key.'_'.'ar']:''
        ];
        $array[$key.'_'.'en']=[
            'input_type'=>'textarea',
            'attributes'=>['rows'=>8],
            'title'=>$value.' (English)',
            'name'=>$key.'_'.'en',
            'placeholder'=>$value.' (English)',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-6',
            'below_div'=>'',
            'value'=>(array_key_exists($key.'_'.'en',$data))?$data[$key.'_'.'en']:''
        ];
    }
    $fields['right_2']=$array;


    $rights=[
        'works_day'=>[
            'name'=>'Work Days',
            'options'=>[
                'saturday'=>'Saturday',
                'sunDay'=>'SunDay',
                'monday'=>'Monday',
                'tuesday'=>'Tuesday',
                'wednesday'=>'Wednesday',
                'thursday'=>'Thursday',
                'friday'=>'Friday',
            ],
            'multiple'=>true
        ],
        'off_day'=>[
            'name'=>'Off Days',
            'options'=>[
                'saturday'=>'Saturday',
                'sunDay'=>'SunDay',
                'monday'=>'Monday',
                'tuesday'=>'Tuesday',
                'wednesday'=>'Wednesday',
                'thursday'=>'Thursday',
                'friday'=>'Friday',
            ],
            'multiple'=>true
        ],
    ];
    $array=[];
    foreach($rights as $key=>$value){

        if($value['multiple']){
            $array[$key]=[
                'input_type'=>'select',
                'type'=>'multi_select_search',
                'title'=>$value['name'],
                'name'=>$key.'[]',
                'placeholder'=>'',
                'class'=>'select2_category',
                'around_div'=>'form-group form-md-line-input',
                'below_div'=>'',
                'col'=>'col-md-6',
                'options'=>$value['options'],
                'selected'=>(array_key_exists($key,$data) && json_decode($data[$key]))?json_decode($data[$key]):[]
            ];
        }else{
            $array[$key]=[
                'input_type'=>'select',
                'type'=>'select_search',
                'title'=>$value['name'],
                'name'=>$key,
                'placeholder'=>'',
                'class'=>'select2_category',
                'around_div'=>'form-group form-md-line-input',
                'below_div'=>'',
                'col'=>'col-md-6',
                'options'=>$value['options'],
                'selected'=>(array_key_exists($key,$data))?$data[$key]:1
            ];
        }

    }
    $fields['right_1']=$array;


    $lefts=[];
    $array=[];
    foreach($lefts as $key=>$value){
        $array[$key.'_'.'image']=[
            "input_type" => "upload_image",
            "type" => "image",
            "title" => $value.' Image',
            "name" => $key.'_'.'image',
            "placeholder" => "",
            "class" => "",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists($key.'_'.'image', $data)) ? readFileStorage($data[$key.'_'.'image']) : ""
        ];
    }
    $fields['left_1']=$array;

    $lefts=[
        'number_of_daily_classes'=>[
            'name'=>'Number Of Daily Classes',
            'type'=>'number',
        ],
        'day_start_at'=>[
            'name'=>'Day Start At',
            'type'=>'time',
        ],
        'day_end_at'=>[
            'name'=>'Day End At',
            'type'=>'time',
        ]
    ];
    $array=[];
    foreach($lefts as $key=>$value){
        $array[$key.'_'.'counter']=[
            'input_type'=>'input',
            "type" => $value['type'],
            'title'=>$value['name'],
            'name'=>$key.'_'.'counter',
            'placeholder'=>$value['name'],
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'col'=>'col-md-12',
            'below_div'=>'',
            'value'=>(array_key_exists($key.'_'.'counter',$data))?$data[$key.'_'.'counter']:''
        ];
    }
    $fields['left_1']=$array;




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
    $fields['right_count']=1;
    $fields['left_count']=1;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_right_1']='Works Time';
    $fields['icon_right_1']='icon-settings';

    $fields['title_right_2']='Static Statements';
    $fields['icon_right_2']='icon-settings';

    $fields['title_left_1']='Works Time';
    $fields['icon_left_1']='icon-settings';

    $fields['title_left_2']='Static Counters';
    $fields['icon_left_2']='icon-settings';
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

