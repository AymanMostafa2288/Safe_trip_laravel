<?php
use App\Models\Seo;
use App\Models\Language;

        if (!function_exists('viewFrontEnd')) {
            function viewFrontEnd($folder, $file='index',$passing_data=[],$theme='frontend'){

                $prefix=(env('APP_MODE')== 'website')?1:2;
                if(env('APP_MODE')== 'website'){
                    if(request()->segment(1)=='en'){
                        app()->setLocale('en');
                    }else{
                        app()->setLocale('ar');
                    }
                    $passing_data['lang_slug']=app()->currentLocale();

                    $url=url()->current();
                    $url_2=str_replace(url('/'), '', $url);
                    $passing_data['seo']=seoManagment($url);

                    if($passing_data['lang_slug']=='ar'){

                        $passing_data['another_lang_url']=env('APP_URL_LANG').'/en'.$url_2;
                    }else{
                        $url= str_replace('/en', '', $url_2);
                        $passing_data['another_lang_url']=env('APP_URL_LANG').$url;
                    }
                }else{

                    if(request()->segment(2)=='en'){
                        app()->setLocale('en');
                    }else{
                        app()->setLocale('ar');
                    }
                    $passing_data['lang_slug']=app()->currentLocale();

                    $url=url()->current();
                    $url_2=str_replace(url('/maintenance'), '', $url);

                    $passing_data['seo']=seoManagment($url);

                    if($passing_data['lang_slug']=='ar'){

                        $passing_data['another_lang_url']=env('APP_URL_LANG_MAINTENANCE').'/en'.$url_2;
                    }else{
                        $url= str_replace('/en', '', $url_2);

                        $passing_data['another_lang_url']=env('APP_URL_LANG_MAINTENANCE').$url;

                    }
                }

                return view('frontend.website.pages.'. $folder . '.' . $file, $passing_data);
            }
        }
        if (!function_exists('getFrontDashboardForm')) {

            function getFrontDashboardForm($file,$id='',$passing_data=[]){

                $form_field = include_once(app_path() .'/Forms/frontend/dashboard/'.$file.'.php');
                $fields=form($passing_data);

                include_once(app_path() .'/Forms/frontend/dashboard/build_form.php');
                return build_form($fields);
            }
        }

        if (!function_exists('getFrontForm')) {
            function getFrontForm($file,$id='',$passing_data=[]){
                $form_field = include_once(app_path() .'/Forms/frontend/website/'.$file.'.php');
                $fields=form($passing_data);
                include_once(app_path() .'/Forms/frontend/website/build_form.php');
                return build_form($fields);
            }
        }

        if (!function_exists('viewFrontDashboardComponents')) {
            function viewFrontDashboardComponents($file,$passing_data=[]){
                $dashboard_theme=config('var.dashboard_theme');
                return view('frontend.component.dashboard.forms.' . $file, $passing_data);
            }
        }

        if (!function_exists('formValidationAjaxCall')) {
            function formValidationAjaxCall($type,$request){
               if($type=='account_email_phone'){
                    $account=$request['account'];
                    $check=DB::table('osoule_account')->where('email',$account)->orWhere('phone',$account)->first();
                    if($check){
                        return true;
                    }
                    $check=DB::table('osoule_delegates')->where('email',$account)->orWhere('phone',$account)->first();
                    if($check){
                        return true;
                    }
               }elseif($type=='account_email'){
                    $account=$request['email'];
                    $check=DB::table('osoule_account')->where('email',$account)->first();
                    if(!$check){
                        return true;
                    }
               }elseif($type=='account_phone'){
                    $account=$request['phone'];
                    $check=DB::table('osoule_account')->where('phone',$account)->orWhere('whatsapp',$account)->first();
                    if(!$check){
                        return true;
                    }
                }elseif($type=='account_whatsapp'){
                    $account=$request['whatsapp'];
                    $check=DB::table('osoule_account')->where('phone',$account)->orWhere('whatsapp',$account)->first();
                    if(!$check){
                        return true;
                    }
                }elseif($type=='account_forget_password'){
                    $account=$request['email'];
                    $check=DB::table('osoule_account')->where('email',$account)->first();
                    if($check){
                        return true;
                    }
                }elseif($type=='account_auth_check_password'){
                    $password=$request['old_password'];
                    $login_by_email=[
                        'email' => auth()->user()->email,
                        'password' => $password,
                    ];
                    if (auth()->attempt($login_by_email)) {
                        return true;
                    }
                }
               return false;
            }
        }

    // Start Api Functions
        if (!function_exists('auth_data')) {
            function authData(){
                $header = request()->header('Authorization');

                if ($header) {
                    $arr=checkAuthData();

                    $user_id=$arr['user_id'];
                    $user_type=$arr['user_type'];
                    if($user_type=='account'){
                        $return=DB::table('osoule_account')->find($user_id);
                    }else{
                        $return=DB::table('osoule_delegates')->find($user_id);
                    }
                    return $return;
                }else{
                    return false;
                }

            }
        }
        if(!function_exists('checkAuthExpiredDays')){
            function checkAuthExpiredDays(){
                $arr=checkAuthData();
                $today=date('Y-m-d');
                $date=date('Y-m-d',strtotime($arr['created_at']));
                $diff =  strtotime($today) - strtotime($date);
                $days=(int)round($diff / (60 * 60 * 24));
                return $days;
            }
        }
        if(!function_exists('checkAuthData')){
            function checkAuthData(){
                $header = request()->header('Authorization');
                $code = json_decode(base64_decode(Crypt::decryptString($header)));
                $arr =(array)$code;
                return $arr;
            }
        }

        if(!function_exists('getAuthUser')){
            function getAuthUser(){

                if(authData()){
                    $user=authData();
                    $auth_id=$user->id;
                    if(isset($user->type)){
                        $auth_type=$user->type;
                    }else{
                        $auth_type='delegate';
                    }

                }elseif(auth()->check()){
                    $auth_id=auth()->user()->id;
                    $auth_type=auth()->user()->type;
                }elseif(auth()->guard('delegate')->check()){
                    $auth_id=auth()->guard('delegate')->user()->id;
                    $auth_type='delegate';
                }else{
                    $auth_id=request()->ip();
                    $auth_type='knowne';
                }
                $user=[];
                $user['user_id']=$auth_id;
                $user['user_type']=$auth_type;
                return $user;

            }
        }

        if(!function_exists('seoManagment')){
            function seoManagment($url){
                $passing_data=[];
                $passing_data['seo_title']='';
                $passing_data['seo_content']='';
                $passing_data['seo_canonical']='';
                $passing_data['seo_keywords']='';
                $passing_data['page_h1']='';
                $passing_data['page_h2']='';
                $passing_data['blog_content']='';
                $passing_data['short_links']=[];
                $passing_data['faqs']=[];
                $passing_data['breadcrumbs']=[];
                $url_arr=[];
                $url_arr[]=$url;
                $url_arr[]=$url.'/';

                $data=Seo::whereIn('url',$url_arr)->first();
                if($data){

                    $page='';
                    if(array_key_exists('page',$_GET)){
                        if($data->section_lang=='en'){
                            $page=' Page '.$_GET['page'];
                        }else{
                            $page=' صفحه رقم '.$_GET['page'];
                        }

                    }

                    if($data->section_lang=='ar'){
                        $passing_data['seo_title']=mb_substr($data->meta_title, 0, 63, 'utf8').$page;
                        if (preg_match('/[فى]/ui', $passing_data['seo_title'])) {
                            $char_replace='فى';
                            $char='في';
                            $passing_data['seo_title']=str_replace($char_replace, $char, $passing_data['seo_title']);
                        }
                        $passing_data['seo_title']=$passing_data['seo_title'];
                    }else{
                        $passing_data['seo_title']=mb_substr($data->meta_title, 0, 61, 'utf8').$page;
                        $passing_data['seo_title']=$passing_data['seo_title'];
                    }
                    $passing_data['seo_content']=mb_substr($data->meta_desc, 0, 120, 'utf8').$page;
                    $passing_data['seo_canonical']=$data->meta_canonical;
                    $passing_data['seo_keywords']=$data->meta_keywords;
                    $passing_data['page_h1']=$data->web_h1;


                    $passing_data['page_h2']=$data->web_h2;
                    $passing_data['blog_content']=$data->web_blog;
                    $passing_data['short_links']=($data->web_short_links)?json_decode($data->web_short_links,true):[];
                    $passing_data['faqs']=($data->web_faqs)?json_decode($data->web_faqs,true):[];
                    $passing_data['breadcrumbs']=($data->breadcrumbs)?json_decode($data->breadcrumbs,true):[];


                }

                return $passing_data;
            }

        }


        if (!function_exists('frontLanguage')) {
            function frontLanguage(){

                if(!session()->has('front_end_language')){

                    // $languages=collect(session()->get('SettingData')['languages']);
                    $main_language=Language::where('slug',appSettings('main_language'))->first();
                    session(['front_end_language'=>$main_language]);
                }
                $return=session()->get('front_end_language');

                return $return;

            }
        }
        if (!function_exists('setFrontLanguage')) {
            function setFrontLanguage($lang){
                // $languages=collect(session()->get('SettingData')['languages']);
                if(session()->has('front_end_language')){
                    session()->flash('front_end_language');
                }

                $language=Language::where('slug',$lang)->first();
                session()->put(['front_end_language'=>$language]);

                return true;
            }
        }

        if(!function_exists('checkLanguage')){
            function checkLanguage(){
                $header = request()->header('lang');
                if ($header) {
                    $lang=request()->header('lang');
                }else{
                    if(session()->has('front_end_language')){
                        $lang=frontLanguage()['slug'];
                    }else{
                        $lang='ar';
                    }
                }
                return $lang;
            }
        }

    // End Api Functions







?>
