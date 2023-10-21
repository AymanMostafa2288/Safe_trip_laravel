<?php

function build_form($data,$wheres=[]){
    if(!empty($wheres)){
        $html='<form action="'.@$data['action'].'/bluck_changes" method="'.@$data['method'].'" class="'.@$data['class'].' submitted-form" id="'.@$data['id'].'" data_id="'.@$data['data_id'].'" enctype="multipart/form-data">';
    }else{
        $html='<form action="'.@$data['action'].'" method="'.@$data['method'].'" class="'.@$data['class'].' submitted-form" id="'.@$data['id'].'" data_id="'.@$data['data_id'].'" enctype="multipart/form-data">';
    }


    if (session('success')){
        $html .='<div id="prefix_1227265261315" class="Metronic-alerts alert alert-success fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.appendToLanguage(getDashboardCurrantLanguage(),'validations',session("success")).'</div>';
    }
    if (session('error')){
        $html .='<div id="prefix_1227265261315" class="Metronic-alerts alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.appendToLanguage(getDashboardCurrantLanguage(),'validations',session("error")).'</div>';
    }
    if (session('errors')){
        $errors=session('errors')->all();
        foreach($errors as $error){
            $html .='<div id="prefix_1227265261315" class="Metronic-alerts alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>'.appendToLanguage(getDashboardCurrantLanguage(),'validations',$error).'</div>';
        }
    }



    if($data["id"]!=''){
        $html .=method_field('PUT') ;
    }
    $html .='<input type="hidden" name="_token" value="'.csrf_token().'">';
    $html .='<input type="hidden" name="id" value="'.$data["id"].'" id="postId">';

    if(array_key_exists('hidden_inputs',$data) && !empty($data['hidden_inputs'])){
        foreach($data['hidden_inputs'] as $key=>$value){
            $html .='<input type="hidden" name="'.$key.'" value="'.$value.'">';
        }

    }
    if(!empty($wheres)){
        foreach($wheres as $where_key=>$where_valuey){
           $key=key($where_valuey);
           $val=$where_valuey[$key];
            $html .='<input type="hidden" name="wheres['.$key.']" value="'.$val.'">';
        }

    }

    $html .='<div class="col-md-8">';
        $count=0;
        $check=false;
        for($i=1;$i<=$data['right_count'];$i++){
            if(array_key_exists('col_right_'.$i,$data)){
                $check=true;
                if($count==0){
                    $html .='<div class="row">';
                }
                $html .='<div class="'.$data['col_right_'.$i].'">';
                $count++;

            }else{
                $html .='<div class="col-md-12">';
            }

                $html .='<div class="portlet light" id="'.strtolower(str_replace(' ', '_', $data['title_right_'.$i])).'_div">
                            <div class="portlet-title">
                                <div class="caption">
                                    <i class="'. $data['icon_right_'.$i] .'"></i>
                                    <span class="caption-subject bold uppercase">'. appendToLanguage(getDashboardCurrantLanguage(),'globals',$data['title_right_'.$i]) .'</span>
                                </div>';
                    if(array_key_exists('input_check_right_'.$i,$data)){
                        $html .='<div class="actions">
                            <div class="md-checkbox-list">
                                <div class="md-checkbox">
                                    <input type="checkbox" class="md-check check_all" id="'.$data['input_check_right_'.$i].'" value="'.$data['input_check_right_'.$i].'">
                                    <label for="'.$data['input_check_right_'.$i].'">
                                    <span></span>
                                    <span class="check"></span>
                                    <span class="box"></span>
                                    '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Check All').' </label>
                                </div>
                            </div>
                        </div>';
                    }

                    $html .='</div>';
                    $html .='<div class="portlet-body form">';
                        $html .='<div class="row">';
                                foreach($data['right_'.$i] as $key_right => $value_right){
                                    if(array_key_exists('col',$value_right)){
                                        $html .='<div class="'.$value_right['col'].' mt-20">';
                                    }else{
                                        $html .='<div class="col-md-12 mt-20">';
                                    }

                                        $html .=viewComponents($value_right['input_type'],$value_right);
                                    $html .='</div>';
                                }

                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';
            if(array_key_exists('col_right_'.$i,$data)){
                if($count==2 || ($i==$data['right_count'] && $check)){
                    $html .='</div>';
                    $count=0;
                }
            }

        }

        $html .='</div>';
    $html .='<div class="col-md-4">';
        if($data['left_corner']){
            for($i=1;$i<=$data['left_count'];$i++){

                $html .='<div class="col-md-12">';
                $html .='<div class="portlet light">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="'. $data['icon_left_'.$i] .'"></i>
                                <span class="caption-subject bold uppercase">'. appendToLanguage(getDashboardCurrantLanguage(),'globals',$data['title_left_'.$i]) .'</span>
                            </div>';
                            if(array_key_exists('input_check_left_'.$i,$data)){
                                $html .='<div class="actions">
                                    <div class="md-checkbox-list">
                                        <div class="md-checkbox">
                                            <input type="checkbox" class="md-check check_all" id="'.$data['input_check_left_'.$i].'" value="'.$data['input_check_left_'.$i].'">
                                            <label for="'.$data['input_check_left_'.$i].'">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span>
                                            '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Check All').' </label>
                                        </div>
                                    </div>
                                </div>';
                            }
                            $html .='</div>';
                $html .='<div class="portlet-body form">';
                    foreach($data['left_'.$i] as $key_left => $value_left){
                        $html .=viewComponents($value_left['input_type'],$value_left);
                    }
                $html .='</div>';
                $html .='</div>';

                $html .='</div>';
            }
        }
        if(array_key_exists('module_id',$data)){
            if(request()->notify_show){
                ChangeNotificationStatus(request()->notify_show);
            }
            $relations=checkCrud($data['module_id']);
            if($relations!=false){

                foreach($relations as $relation){
                    if(count($relation->fields)==2){

                        $html .='<div class="col-md-12">';
                        $html .='<div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject bold uppercase">'. appendToLanguage(getDashboardCurrantLanguage(),'globals',$relation->name) .'</span>
                                    </div>
                                </div>';
                        $html .='<div class="portlet-body form">';
                        $field_design=$relation->fields[0];
                        if($data['id']!=''){
                            $main_table=getDBFieldsTable($data['module_id'],true);
                            foreach($relation->fields as $field){
                                if($field->related_with==$main_table){
                                    $main_field=$field->name;
                                }else{
                                    $another_field=$field->name;
                                }
                            }
                            $selected=selectedOption($main_field,$data['id'],$another_field,$relation->table_db);
                        }else{
                            $selected=[];
                        }
                        $fields=[
                            'input_type'=>'select',
                            'type'=>'multi_select_search',
                            'title'=>appendToLanguage(getDashboardCurrantLanguage(),'globals',$field_design->show_as),
                            'name'=>$field_design->name.'[]',
                            'placeholder'=>'',
                            'class'=>'select2_category',
                            'around_div'=>'form-group form-md-line-input',
                            'col'=>'',
                            'below_div'=>($field_design->hint)?$field_design->hint:'',
                            'options'=>getValueByTableName($field_design->related_with,['name'],['is_active'=>1]),
                            'selected'=>$selected,
                        ];
                        $html .=viewComponents($fields['input_type'],$fields);
                        $html .='</div>';
                        $html .='</div>';

                        $html .='</div>';
                    }

                }
            }

        }

        if($data['show_button']){
            $html .='<div class="col-md-12">';
                $html .=' <div class="portlet light">';
                    $html .=' <div class="portlet-body form" style="text-align: center;">';
                        if($data['send_mail']!=false){
                            $html .=' <button type="submit" class="btn green" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Send '.$data['send_mail']).'</button>';
                        }
                        if($data['button_save']){
                            $html .=' <button type="submit" name="save" class="btn green" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Save').'</button>';
                        }
                        if($data['button_save_edit']){
                            $html .=' <button type="submit" name="save_and_edit" class="btn green" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Save&Edit').'</button>';
                        }
                        if($data['button_clear']){
                            $html .='<button type="button" class="btn default" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Clear').'</button>';
                        }

                        if(array_key_exists('translate',$data) && $data['translate']){
                            $html .='<a href="'.$data["translate_href"].'" class="btn btn-primary" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Translate').'</a>';
                        }
                        if(array_key_exists('url_content',$data) && $data['url_content']){
                            $html .='<a data-toggle="modal" href="#basic" class="btn btn-primary" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','URL').'</a>';
                            $html .='<div class="modal fade" id="basic" tabindex="-1" role="basic" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h4 class="modal-title">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','URL').'</h4>
                                        </div>
                                        <div class="modal-body">
                                                <input type="text" class="form-control" placeholder="" name="link_content" value="'.url('/').'/'.$data['url_content_value'].'">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn default" data-dismiss="modal">Close</button>
                                            <a href="'.url('/').'/'.$data['url_content_value'].'" target="_blank" class="btn btn-success" >'.appendToLanguage(getDashboardCurrantLanguage(),'globals','GO To Link').'</a>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>';
                        }


                    $html .='</div>';
                $html .='</div>';
            $html .='</div>';

            $html .='<div class="col-md-12">';
            $html .=' <div class="portlet light">';
            $html .=' <div class="portlet-body form" style="text-align: center;">';
            if(array_key_exists('custom_buttons',$data)){
                if($data['custom_buttons']){
                    foreach($data['custom_buttons_tags'] as $button){
                        if($button['type'] == 'submit' || $button['type'] == 'button'){
                            $html .='<button type="'.$button['type'].'" class="btn '.$button['color'].'" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals',$button['name']).'</button>';
                        }elseif($button['type'] == 'link'){
                            if(array_key_exists('blank',$button)){
                                if($button['blank']){
                                    $html .='<a href="'.$button['href'].'" target="_blank" class="btn '.$button['color'].'" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals',$button['name']).'</a>';
                                }else{
                                    $html .='<a href="'.$button['href'].'" class="btn '.$button['color'].'" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals',$button['name']).'</a>';
                                }

                            }else{
                                $html .='<a href="'.$button['href'].'"  class="btn '.$button['color'].'" style="margin-top: 5px;">'.appendToLanguage(getDashboardCurrantLanguage(),'globals',$button['name']).'</a>';
                            }

                        }

                    }
                }
            }
            $html .='</div>';
            $html .='</div>';
            $html .='</div>';
        }

    $html .='</div>';
    $html .='<div class="col-md-12">';
        $count=0;
        $check=false;
        if(array_key_exists('full_count',$data)){
            for($i=1;$i<=$data['full_count'];$i++){
                if(array_key_exists('col_full_'.$i,$data)){
                    $check=true;
                    if($count==0){
                        $html .='<div class="row">';
                    }
                    $html .='<div class="'.$data['col_full_'.$i].'">';
                    $count++;

                }else{
                    $html .='<div class="col-md-12">';
                }

                    $html .='<div class="portlet light">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="'. $data['icon_full_'.$i] .'"></i>
                                        <span class="caption-subject bold uppercase">'. appendToLanguage(getDashboardCurrantLanguage(),'globals',$data['title_right_'.$i]) .'</span>
                                    </div>';


                        $html .='</div>';
                        $html .='<div class="portlet-body form">';
                            $html .='<div class="row">';
                                    foreach($data['full_'.$i] as $key_full => $value_full){
                                        if(array_key_exists('col',$value_full)){
                                            $html .='<div class="'.$value_full['col'].' mt-20">';
                                        }else{
                                            $html .='<div class="col-md-12 mt-20">';
                                        }
                                        $html .=viewComponents($value_full['input_type'],$value_full);
                                        $html .='</div>';
                                    }

                            $html .='</div>';
                        $html .='</div>';
                    $html .='</div>';
                $html .='</div>';
                if(array_key_exists('col_full_'.$i,$data)){
                    if($count==2 || ($i==$data['full_count'] && $check)){
                        $html .='</div>';
                        $count=0;
                    }
                }

            }
        }

    $html .='</div>';

    $html .='</form>';
    return $html;

}
