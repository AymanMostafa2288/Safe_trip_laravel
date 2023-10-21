<?php

    function build_table($data){
        $html ='';
        if($data['table']['filter']===true){
            if(array_key_exists('bulck_action',$data['table']) && $data['table']['bulck_action']){
                $get=$_GET;
                unset($get['page']);
                $param=http_build_query($get);
                $url_for_blick_change=$data['main_url'].'/show?bluckChanges=1&'.$param;
            }


            $html .='<div class="col-md-12">
            <div class="portlet light">
                <div class="portlet-title">';
            $html .='<div class="caption"><i class="fa fa-search"></i> '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Search').' </div>
            <div class="tools">';
            if(empty($_GET)){
                $html .=' <a href="javascript:;" class="expand" data-original-title="" title=""></a>';
            }else{
                $html .=' <a href="javascript:;" class="collapse" data-original-title="" title=""></a>';
            }

            $html .='</div>
            </div>';
            if(empty($_GET)){
                $html .='<div class="portlet-body form" style="display:block">';
            }else{
                $html .='<div class="portlet-body form" style="display:block">';
            }

            $html .='<form enctype="multipart/form-data">';
            $html .='<div class="row">';

                    foreach($data['filter'] as $key_left => $value_left){
                        $html .=viewComponents($value_left['input_type'],$value_left);
                    }

            $html .='<div class="col-md-12" style="text-align: end;">';
            $html .=' <button type="submit" class="btn green"><i class="fa fa-search"></i> '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Filter').'</button>';
            if(array_key_exists('bulck_action',$data['table']) && $data['table']['bulck_action']){
                $html .=' <a href="'.$url_for_blick_change.'" class="btn blue" >'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Bluck Changes').'</a>';
            }

            $html .=' <a href="'.$data['main_url'].'" class="btn gray" >'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Clear').'</a>';
            $html .='</div>';
            $html .='</div>';
            $html .='</form>
            </div>';
            $html .='</div></div>';
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
        $html .='<div class="col-md-12">
                    <div class="portlet light">
                        <div class="portlet-title">';
        $html .='<div class="caption">'.appendToLanguage(getDashboardCurrantLanguage(),'globals',$data['action']['name']).'</div>';
        $html .='<div class="actions">';
        if($data['table']['add']===true){
            $html .='<a href="'.$data['table']['add_link'].'" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i>'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Add New').' </a>';
        }
        if($data['table']['status_change']===true){
            $html .='<div class="btn-group">
                        <a class="btn btn-default btn-sm" href="javascript:;" data-toggle="dropdown">
                        <i class="fa fa-cogs"></i> Status <i class="fa fa-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li>
                                <a href="javascript:;">Block </a>
                            </li>
                            <li>
                                <a href="javascript:;">Active </a>
                            </li>
                        </ul>
                    </div>';
        }
        if($data['table']['delete_all']===true){
            $html .='<a  class="btn btn-danger btn-sm" data-toggle="modal" disabled="disabled" id="delete_btn_all" data-target="#rowDeleteMulti"><i class="fa fa-trash-o"></i> '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Delete').' </a>';

            $html .='<div class="modal fade bd-example-modal-sm" id="rowDeleteMulti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Delete').'</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Are You Sure ?').'
                    </div>
                    <div class="modal-footer">
                    <form method="POST" action="'.$data['table']['delete_link'].'/delete_all">
                        <input type="hidden" name="_token" value="'.csrf_token().'">
                        <input type="hidden" name="_method" value="DELETE">
                        <div id="ids_deleted"></div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Close').'</button>
                        <button type="submit" class="btn btn-danger">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Delete').'</button>
                    </form>

                    </div>
                </div>
                </div>
            </div>';
        }
        if(array_key_exists('export_excel',$data['table']) && $data['table']['export_excel']==true){
            $html .='<a style="margin-left: 4px;" href="'.request()->fullUrl().'" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i> Export Excel </a>';
        }

        $html .='
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr style="text-align:center">';
                                        if($data['table']['multi_select']==true){
                                            $html .='<th class="table-checkbox"></th>';
                                        }
                                        foreach($data['head'] as $head){
                                            $html .='<th style="text-align:center">'.appendToLanguage(getDashboardCurrantLanguage(),'globals',$head).'</th>';
                                        }
                                    $html .='</tr>
                                </thead>
                                <tbody>';
                                if(count($data['body']) < 1){
                                    $count_head=count($data['head'])+1;
                                    $html .='<tr class="odd gradeX">
                                        <th style="text-align:center" colspan="'.$count_head.'">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','No Data Found').'</th>
                                    </tr>';
                                }
                                if(!array_key_exists('body_length',$data)){
                                    $data['body_length']=40;
                                }
                                foreach($data['body'] as $body){
                                    $html .='<tr class="odd gradeX" style="text-align: center">';

                                        if($data['table']['multi_select']==true){
                                            $html .='<td style="text-align:center">';
                                            if(!in_array($body['id'],$data['action']['delete_without'])){
                                                $html .='<input type="checkbox" class="checkboxes check_delete_multi" value="'.$body['id'].'"/>';
                                            }

                                            $html .='</td>';
                                        }

                                        foreach($data['head'] as $head_key=>$head){
                                            if(!in_array($head_key,['action_buttons','pagination'])){
                                                if(array_key_exists('head_select',$data)){

                                                    if(in_array($head_key,$data['head_select']['db'])){

                                                        $arr_options=$data['head_select']['db_option'][$head_key];

                                                        $arr_options=explode('_',$arr_options);
                                                        $table=$arr_options[0];
                                                        unset($arr_options[0]);
                                                        $field=implode('_',$arr_options);
                                                        $str_option=$body[$table][$field];
                                                        $html .='<td style="text-align:center">'.$str_option.'</td>';
                                                    }elseif(in_array($head_key,$data['head_select']['select'])){

                                                        $arr_options=$data['head_select']['select_option'][$head_key];
                                                        if(array_key_exists($head_key.'_color',$data['head_select']['select_option'])){
                                                            $colors=$data['head_select']['select_option'][$head_key.'_color'];
                                                            $html .='<td style="text-align:center"><span class="label" style="background-color:'.$colors[$body[$head_key]].'">'.$arr_options[$body[$head_key]].'</span></td>';
                                                        }else{
                                                            $html .='<td style="text-align:center"><span class="label label-success">'.$arr_options[$body[$head_key]].'</span></td>';
                                                        }

                                                    }else{
                                                        $html .='<td>'. mb_substr($body[$head_key], 0,  $data['body_length'], 'utf8').'</td>';
                                                    }
                                                }elseif(array_key_exists('images_table',$data) && in_array($head_key,$data['images_table'])){
                                                    $html .='<td style="text-align:center"><img src="'.$body[$head_key].'" style="width:50px;height:50px"></td>';
                                                }else{


                                                    $html .='<td style="text-align:center">'.mb_substr($body[$head_key], 0,  $data['body_length'], 'utf8').'</td>';
                                                }


                                            }
                                        }
                                        $string_query='';
                                        if($data['action']['edit']==true || $data['action']['delete']==true || $data['action']['view']==true || !empty($data['action']['links'])){
                                            $html .='<td style="text-align:center">';
                                            if($data['action']['edit']==true){
                                                if(!in_array($body['id'],$data['action']['edit_without'])){

                                                    if(!empty($_GET)){
                                                        foreach($_GET as $key=>$value){
                                                            $string_query='?'.$key.'='.$value.'&';
                                                        }
                                                    }
                                                    $html .='<a href="'.$data['table']['edit_link'].'/'.$body['id'].$string_query.'" class="btn btn-icon-only blue"><i class="fa fa-pencil"> </i></a>';
                                                }

                                            }

                                            if($data['action']['view']==true){
                                                if(!in_array($body['id'],$data['action']['view_without'])){
                                                    $html .='<a href="'.$data['table']['view_link'].'/'.$body['id'].'" class="btn btn-icon-only default"><i class="fa fa-eye"></i></a>';
                                                }
                                            }
                                            if(!empty($data['action']['links'])){
                                                foreach($data['action']['links'] as $href){
                                                    if(!in_array($body['id'],$data['action']['links_without'])){
                                                        $link=$href['href'];

                                                        if(!empty($href['param'])){
                                                            $link=$href['href'].'?';
                                                            $count_param=count($href['param']);
                                                            $count=0;
                                                            foreach($href['param'] as $param){
                                                                $count++;
                                                                if($count==$count_param){
                                                                    if(is_array($param)){
                                                                       $show_as=key($param);
                                                                       $value=$body[$param[$show_as]];
                                                                    }else{
                                                                        $show_as=$param;
                                                                        $value=$body[$show_as];
                                                                    }
                                                                    $link=$link.$show_as.'='.$value;
                                                                }else{
                                                                    $link=$link.$param.'='.$body[$param].'&';
                                                                }


                                                            }
                                                        }
                                                        $html .='<a href="'.$link.'" class="btn btn-default">'.$href['name'].'</a>';
                                                    }
                                                }

                                            }
                                            if($data['action']['delete']==true){
                                                if(!in_array($body['id'],$data['action']['delete_without'])){
                                                    if(!empty($_GET)){
                                                        foreach($_GET as $key=>$value){
                                                            $string_query='?'.$key.'='.$value.'&';
                                                        }
                                                    }
                                                    $html .='<a href="javascript:;" class="btn btn-icon-only red"  data-toggle="modal" data-target="#rowDelete'.$body['id'].'"><i class="fa fa-trash-o"></i></a>';
                                                    $html .='<div class="modal fade bd-example-modal-sm" id="rowDelete'.$body['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-sm" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Delete').'</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    '.appendToLanguage(getDashboardCurrantLanguage(),'globals','Are You Sure ?').'
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                    <form method="POST" action="'.$data['table']['delete_link'].'/'.$body['id'].$string_query.'">
                                                                        <input type="hidden" name="_token" value="'.csrf_token().'">
                                                                        <input type="hidden" name="_method" value="DELETE">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Close').'</button>
                                                                        <button type="submit" class="btn btn-danger">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Delete').'</button>
                                                                    </form>

                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>';
                                                }
                                            }

                                            $html .='</td>';
                                        }

                                    $html .='</tr>';
                                }

                        $html .='</tbody>
                            </table>';

                        if(array_key_exists('pagination',$data) && $data['pagination']!=false){
                            $total=$data['pagination'];
                            $page=$data['page'];
                            if($page >=1 && $page < 6){

                                $start=1;
                                $end=10;
                            }else{
                                $start=$page-4;
                                $end=$page+5;
                            }
                            if($end >= $total && $start > 10){
                                $start=$page-8;
                                $end=$total;
                            }
                            if($end >= $total){
                                $end=$total;
                            }


                            $next_page=$page+1;
                            $previous_page=$page-1;
                            $previous_page=($previous_page < 1)?1:$previous_page;
                            $next_page=($next_page > $end)?$end:$next_page;
                            $get=$_GET;
                            unset($get['page']);
                            if (strpos($data['main_url'], '?') !== false) {
                                $main_url=$data['main_url'].'&page=';
                            }else{
                                $main_url=$data['main_url'].'?page=';
                            }
                            $html .='<div class="btn-group">
                                        <a href="'.$main_url.''.$previous_page.'"  type="button" class="btn btn-default">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Previous').'</a>';
                                        for($i=$start;$i<=$end;$i++){
                                            if($i==$page){
                                                $html .='<a href="'.$main_url.''.$i.'&'.http_build_query($get).'"type="button" class="btn btn-default" style="background-color: orange;">'.$i.'</a>';
                                            }else{
                                                $html .='<a href="'.$main_url.''.$i.'&'.http_build_query($get).'"type="button" class="btn btn-default">'.$i.'</a>';
                                            }

                                        }
                            $html .=' <a href="'.$main_url.''.$next_page.'" type="button" class="btn btn-default">'.appendToLanguage(getDashboardCurrantLanguage(),'globals','Next').'</a>
                            </div>';
                        }

                    $html .='</div>
                    </div>
                </div>';

                return $html;


    }
?>
