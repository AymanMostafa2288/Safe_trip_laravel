<?php

function build_form($data){
    $html='<div class="gray-bg small-padding fl-wrap">div class="container">';
    $html.='<div class="list-searh-input-wrap-title fl-wrap">';

    $html.='<i class="fas fa-sliders-h"></i><span>Search</span>';

    $html.=' </div>';
    $html .='<form action="'.@$data['data']['action'].'" method="'.@$data['data']['method'].'" class="'.@$data['data']['class'].'" id="'.@$data['data']['id'].'" enctype="multipart/form-data">';


    if (session('success')){
        $html.='<div class="notification success-notif  fl-wrap">
                <p>'.session("success").'</p>
                <a class="notification-close" href="#"><i class="fas fa-times"></i></a>
            </div> ';

    }
    if (session('error')){

        $html.='<div class="notification success-notif  fl-wrap">
                <p>'.session("error").'</p>
                <a class="notification-close" href="#"><i class="fas fa-times"></i></a>
            </div> ';
    }
    if (session('errors')){
        $errors=session('errors')->all();
        foreach($errors as $error){
            $html.='<div class="notification success-notif  fl-wrap">
                <p>'.$error.'</p>
                <a class="notification-close" href="#"><i class="fas fa-times"></i></a>
            </div> ';
        }

    }

    if($data['data']["field_id"]!=''){
        $html .=method_field('PUT') ;
    }
    $html .='<input type="hidden" name="_token" value="'.csrf_token().'">';
    $html .='<input type="hidden" name="id" value="'.$data['data']["field_id"].'" id="postId">';
    if(array_key_exists('hidden',$data['data']) && !empty($data['data']['hidden'])){
        foreach($data['data']['hidden'] as $hidden_key=>$hidden_value){
            $html .='<input type="hidden" name="'.$hidden_key.'" value="'.$hidden_value.'">';
        }
    }


    $html.='<div class="custom-form fl-wrap">';
    $html.='</div>';
    $html .='</form>';
    $html.='</div></div>';
    return $html;
}
?>

