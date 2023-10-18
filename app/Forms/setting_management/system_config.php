<?php


function form($data=[]){

    $fields=[];

    $fields['left_1']=[
        'APP_Mode'=>[
            'input_type'=>'select',
            'title'=>'App Mode',
            'name'=>'app_mode',
            'placeholder'=>'Select App Mode',
            'class'=>'',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'production'=>'Production',
                'development'=>'Development',
                'maintenance'=>'Maintenance',
            ],
            'selected'=>(array_key_exists('app_mode',$data))?$data['app_mode']:''
        ],
        'APP_Main_Language'=>[
            'input_type'=>'select',
            'title'=>'Application',
            'name'=>'main_language',
            'placeholder'=>'Select Main Language',
            'class'=>'select2_category',
            'col'=>'col-md-6',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'ar'=>'Arabic',
                'en'=>'English',
            ],
            'selected'=>(array_key_exists('main_language',$data))?$data['main_language']:''
        ],
    ];



    $fields['right_1']=[
        'fields'=>[
            'input_type'=>'multi_record',
            'type'=>'dashboard_departments',
            'title'=>'Department',
            'name'=>'departments',
            'options'=>form_options(),
            'values'=>(array_key_exists('departments',$data))?json_decode($data['departments'],true):[],

        ],

    ];
    $fields['right_2']=[
        'Image_Chunk_Size'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Chunk Size',
            'name'=>'image_chunk_size',
            'placeholder'=>'Chunk Size',
            'class'=>'',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('image_chunk_size',$data))?$data['image_chunk_size']:''
        ],
        'Image_Enable_Watermark'=>[
            'input_type'=>'select',
            'title'=>'Enable Watermark',
            'name'=>'image_enable_watermark',
            'placeholder'=>'Enable Watermark',
            'class'=>'',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'yes'=>'Yes',
                'no'=>'No',
            ],
            'selected'=>(array_key_exists('image_enable_watermark',$data))?$data['image_enable_watermark']:''
        ],

        'Image_Watermark_Size'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Watermark Size(%)',
            'name'=>'image_Watermark_size',
            'placeholder'=>'Watermark Size(%)',
            'class'=>'',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('image_Watermark_size',$data))?$data['image_Watermark_size']:''
        ],
        'Image_Watermark_Opacity'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Watermark Opacity(%)',
            'name'=>'image_Watermark_opacity',
            'placeholder'=>'Watermark Opacity(%)',
            'class'=>'',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('image_Watermark_opacity',$data))?$data['image_Watermark_opacity']:''
        ],
        'Image_Watermark_Position'=>[
            'input_type'=>'select',
            'title'=>'Watermark Position',
            'name'=>'image_watermark_position',
            'placeholder'=>'Watermark Position',
            'class'=>'',
            'col'=>'col-md-4',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'options'=>[
                'top_left'=>'Top Left',
                'top_right'=>'Top Right',
                'bottom_left'=>'Bottom Left',
                'bottom_right'=>'Bottom Right',
                'center'=>'Center',
            ],
            'selected'=>(array_key_exists('image_watermark_position',$data))?$data['image_watermark_position']:''
        ],

        'Image_Type'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'image_type',
            'col'=>'col-md-4',
            'title'=>'Image Type',
            'options'=>[
                'png'=>'png',
                'jpg'=>'jpg',
                'jpeg'=>'jpeg',
                'webp'=>'webp',

            ],
            'selected'=>(array_key_exists('image_type',$data))?json_decode($data['image_type'],true):[]
        ],

        'Image_Watermark'=>[
            'input_type'=>'upload_image',
            'title'=>'Watermark',
            'name'=>'image_watermark',
            'placeholder'=>'',
            'class'=>'select2_category',
            'col'=>'col-md-6',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('image_watermark',$data))?readFileStorage($data['image_watermark']):''
        ],
        'File_Chunk_Size'=>[
            'input_type'=>'input',
            'type'=>'number',
            'title'=>'Chunk Size',
            'name'=>'file_chunk_size',
            'placeholder'=>'Chunk Size',
            'class'=>'',
            'col'=>'col-md-6',
            'around_div'=>'form-group form-md-line-input',
            'below_div'=>'',
            'value'=>(array_key_exists('file_chunk_size',$data))?$data['file_chunk_size']:''
        ],


        'File_Type'=>[
            'input_type'=>'checkbox',
            'type'=>'inline', // list
            'name'=>'file_type',
            'col'=>'col-md-12',
            'title'=>'File Type',
            'options'=>[
                'pdf'=>'pdf',
                'txt'=>'txt',
                'excel'=>'excel',
                'csv'=>'csv',

            ],
            'selected'=>(array_key_exists('file_type',$data))?json_decode($data['file_type'],true):[]
        ],
    ];
    $fields["right_3"] = [
        "maintenance_mode_page" => [
            "input_type" => "textarea",
            "attributes" => ["rows" => 4],
            "type" => "text_editor",
            "title" => "",
            "name" => "maintenance_mode_page",
            "placeholder" => "Maintenance Mode Page",
            "class" => "ckeditor",
            "around_div" => "form-group form-md-line-input",
            "value" => (array_key_exists("maintenance_mode_page", $data)) ? $data["maintenance_mode_page"] : old("maintenance_mode_page")
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
    $fields['right_count']=3;
    $fields['left_count']=1;
    $fields['left_corner']=true;
    $fields['show_button']=true;
    return $fields;
}
function form_design($fields){
    $fields['title_left_1']='App Setting';
    $fields['icon_left_1']='icon-settings ';

    $fields['title_right_1']='Dashboard Departments';
    $fields['icon_right_1']='icon-settings';

    $fields['title_right_2']='File And Image Configrations';
    $fields['icon_right_2']='icon-settings';


    $fields['title_right_3']='Maintenance Page';
    $fields['icon_right_3']='icon-settings';




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
