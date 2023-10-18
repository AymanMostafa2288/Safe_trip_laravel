<?php

use App\Enum\NotificationEnum;
use App\Enum\NotificationTypeEnum;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\setting_management\GeneralInterface;
use App\Repositories\Interfaces\builder_management\ModuleFieldsInterface;
use App\Repositories\Interfaces\builder_management\CounterInterface;
use App\Repositories\Interfaces\builder_management\ReportInterface;
use Illuminate\Support\Facades\App;
use App\Models\Admin;
use App\Models\Notification;
use App\Models\Language;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

if(!function_exists('currentLanguage')){
    function currentLanguage($field_translate,$key,$item,$in_table=false){
        $return=$item->$key;
        if(session()->has('language_dashboard')){
            $locale=session()->get('language_dashboard');

            if($in_table){
                $key=$key.'_'.$locale;
                $key=$item->$key;
                $return=$key;
            }else{
                if(array_key_exists($locale,$field_translate)){
                    $return=$field_translate[$locale][$key];
                }
            }


        }else{

            if(request()->segment(1)=='en'){
                app()->setLocale('en');
            }else{
                app()->setLocale('ar');
            }
            $locale=app()->currentLocale();
            if($in_table){
                $key=$key.'_'.$locale;
                $key=$item->$key;
                $return=$key;
            }else{
                if(array_key_exists($locale,$field_translate)){
                    $return=$field_translate[$locale][$key];
                }
            }

        }
        return $return;
    }
}
if (!function_exists('viewBackend')) {

    function viewBackend($folder, $file='index',$passing_data=[]){
        $dashboard_theme=config('var.dashboard_theme');
        $locale='en';
        if(session()->has('language_dashboard')){
            $locale=session()->get('language_dashboard');
        }
        $passing_data['lang']=$locale;
        return view('backend.pages.'. $dashboard_theme .'.' . $folder . '.' . $file, $passing_data);
    }
}


if (!function_exists('viewComponents')) {
    function viewComponents($file,$passing_data=[]){
        $dashboard_theme=config('var.dashboard_theme');
        return view('backend.component.'. $dashboard_theme .'.' . $file, $passing_data);
    }
}

if (!function_exists('getForm')) {

    function getForm($file,$id='',$passing_data=[],$wheres='',$formType='edit'){

        $form_field = include_once(app_path() .'/Forms/'.$file.'.php');
        $fields=form($passing_data,$formType);
        include_once(app_path() .'/Forms/build_form.php');
        return build_form($fields,$wheres);
    }
}

if (!function_exists('getFormTranslate')) {

    function getFormTranslate($file,$passing_data=[]){

        $form_field = include_once(app_path() .'/Forms/Translate'.$file.'.php');

        $fields=form($passing_data);

        include_once(app_path() .'/Forms/Translate/build_form.php');
        return build_form($fields);
    }
}

if (!function_exists('getTable')) {

    function getTable($file,$passing_data=[]){
        include_once(app_path('/Tables/'.$file.'.php'));
        $rows=table($passing_data);
        include_once(app_path() .'/Tables/build_table.php');
        return build_table($rows);
    }
}

if(!function_exists('getDBTable')){
    function getDBTable(){
        $migration_table_name='cms_migration';
        $DB_tables = DB::select('SHOW TABLES');
        $main_database=env('DB_DATABASE');
        $DB_tables =json_decode(json_encode($DB_tables),true);
        $tables=[];
        $install_tables=[$migration_table_name,
            'install_counters',
            'install_modules',
            'install_settings',
            'install_module_fields',
            'failed_jobs',
            'install_branches',
            'install_codes',
            'install_languages',
            'install_module_fields_translate',
            'install_permissions',
            'install_permission_moduels',
            'install_permission_moduel_roles',
            'install_roles',
            'install_slug',
            'jobs',
            'migrations'
        ];
        foreach($DB_tables as $table_key=>$table_value){

            if(!in_array($table_value['Tables_in_'.$main_database],$install_tables)){
                $tables[$table_value['Tables_in_'.$main_database]]=$table_value['Tables_in_'.$main_database];
            }
        }
        return $tables;
    }
}

if(!function_exists('getDepartments')){
    function getDepartments($with_icon=false,$parent='Parent') {
        $departments=app(GeneralInterface::class)->data('departments');

        $departments=json_decode($departments,true);

        $return=[];
        $count=0;
        if(!$with_icon){
            $return['without_department']='Without Departments';
        }
        if($departments){
            if($with_icon){
                foreach($departments['name'] as $value){
                    if($departments['parent'][$count]==$parent){
                        $return[$departments['order'][$count]]=[
                            'title'=>$departments['title'][$count],
                            'name'=>$departments['name'][$count],
                            'icon'=>$departments['icone'][$count],
                            'parent'=>$departments['parent'][$count]
                        ];
                    }
                    $count++;
                }
            }else{

                foreach($departments['name'] as $value){
                    $return[$departments['name'][$count]]=$departments['title'][$count];
                    $count++;
                }
            }
        }



        return $return;
    }
}

if(!function_exists('checkDepartmentActive')){
    function checkDepartmentActive($department,$uri){
        $request=[];
        $request['where']=[];
        $request['where'][]=['with_group'=>$department];
        $request['where'][]=['is_active'=>1];
        $request['select']=['route_repo'];
        $modules=app(ModuleInterface::class)->data($request);
        $dashboard_route = config('var.dashboard_route');
        $sub_departments=getDepartments(true,$department);
        $sub_modules=[];
        if(!empty($sub_departments)){
            foreach($sub_departments as $sub_department){
                $request['where']=[];
                $request['where'][]=['with_group'=>$department];
                $request['where'][]=['is_active'=>1];
                $request['select']=['route_repo'];
                $sub_modules=app(ModuleInterface::class)->data($request);
            }
        }

        $arr=[];
        foreach($modules as $module){
            $arr[]=$dashboard_route.'/'.'modules/'.$module->route_repo;
        }
        foreach($sub_modules as $sub_department){
            $arr[]=$dashboard_route.'/'.'modules/'.$sub_department->route_repo;
        }
        if(in_array($uri,$arr)){
            return true;
        }
        return false;
    }
}


if(!function_exists('getModulesFromGroup')){
    function getModulesFromGroup($department,$show_in_left_side=true){
        $request=[];
        $request['where']=[];
        $request['where'][]=['with_group'=>$department];
        $request['where'][]=['is_active'=>1];
        if($show_in_left_side){
            $request['where'][]=['show_in_left_side'=>1];

        }
        $request['select']=['id','name','route_repo'];
        $modules=app(ModuleInterface::class)->data($request);
        return $modules;
    }

}


if(!function_exists('geModuleDepartments')){
    function geModuleDepartments($id,$all=false){
        $departments=app(ModuleInterface::class)->data([],$id,'departments_module');
        $departments=json_decode($departments,true);
        $return=[];
        $count=0;
        foreach($departments['order'] as $department){
            if($all){
                $return[$departments['order'][$count]]=[
                    'title'=>$departments['title'][$count],
                    'side'=>$departments['side'][$count],
                    'icon'=>$departments['icone'][$count],
                    'name'=>$departments['name'][$count],
                ];
            }else{
                $return[$departments['name'][$count]]=$departments['title'][$count];
            }

            $count++;
        }
        return $return;
    }
}

if(!function_exists('getDBFieldsTable')){
    function getDBFieldsTable($id,$table_name=false,$fields=false){
        $table=app(ModuleInterface::class)->data([],$id,'table_db');
        if($table_name){
            return $table;
        }
        $DB_Fields = DB::select('SHOW COLUMNS FROM '.$table);
        $DB_Fields =json_decode(json_encode($DB_Fields),true);

        $tables=[];
        $main_fields=['id','created_at','updated_at'];
        foreach($DB_Fields as $key=>$field){
            if(!in_array($field['Field'],$main_fields)){
                if($fields){
                    $tables[$field['Field']]=$field;
                }else{
                    $tables[$field['Field']]=$field['Field'];
                }

            }
        }
        return $tables;
    }
}



if(!function_exists('getIcons')){
    function getIcons(){
        return [
            'icon-info'=>'icon-info',
            'icon-link'=>'icon-link',
            'icon-settings'=>'icon-settings',
            'icon-tag'=>'icon-tag',
            'icon-eye'=>'icon-eye',
            'icon-pointer'=>'icon-pointer',
            'icon-cloud-upload'=>'icon-cloud-upload',
            'icon-user'=>'icon-user',
            'icon-user-female'=>'icon-user-female',
            'icon-users'=>'icon-users',
            'icon-user-follow'=>'icon-user-follow',
            'icon-speedometer'=>'icon-speedometer',
            'icon-book-open'=>'icon-book-open',
            'icon-symbol-female'=>'icon-symbol-female',
            'icon-symbol-male'=>'icon-symbol-male',
            'icon-target'=>'icon-target',
            'icon-volume-1'=>'icon-volume-1',
            'icon-volume-2'=>'icon-volume-2',
            'icon-volume-off'=>'icon-volume-off',
            'icon-bell'=>'icon-bell',
            'icon-screen-desktop'=>'icon-screen-desktop',
            'icon-wallet'=>'icon-wallet',
            'icon-earphones-alt'=>'icon-earphones-alt',
            'icon-home'=>'icon-home',
            'icon-notebook'=>'icon-notebook',



        ];
    }

}

if(!function_exists('getField')){
    function getField($field){
        /*
         'text'=>'Text',
        'hidden'=>'Hidden',
        'number'=>'Number',
        'email'=>'Email',
        'password'=>'Password',
        'date'=>'DATE',
        'time'=>'time',
        'date_time'=>'Date Time',
        'checkbox'=>'Check Box',
        'radio_button'=>'Radio Button',
        'text_area'=>'Text Area',
        'text_editor'=>'Text Editor',
        'image'=>'Image',
        'multi_image'=>'Multi Image',
        'file'=>'File',
        'multi_file'=>'Multi File',
        'record'=>'Record',
        'video'=>'Video',
        'select'=>'Select',
        'select_search'=>'Select With Search',
        'multi_select'=>'Multi Select',
        'multi_select_search'=>'Multi Select With Search',
        'tags'=>'Tags',
        */
        $code='';
        if(in_array($field['type'],['text','hidden','number','email','password','tags'])){
            $code .="\n";
            $code .='"'.$field['name'].'"=>[';
            $code .="\n";
            $code .='"input_type"=>"input",';
            $code .="\n";
            if($field['type']=='tags'){
                $code .='"type"=>"hidden",';
            }else{
                $code .='"type"=>"'.$field['type'].'",';
            }

            $code .="\n";
            $code .='"title"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .='"name"=>"'.$field['name'].'",';
            $code .="\n";
            $code .='"placeholder"=>"'.$field['show_as'].'",';
            $code .="\n";
            if($field['type']=='tags'){
                $code .='"class"=>"select2_sample3",';
            }else{
                $code .='"class"=>"",';
            }

            $code .="\n";
            $code .='"around_div"=>"form-group form-md-line-input",';
            $code .="\n";
            $code .='"col"=>"'.($field['around_div'])?$field['around_div']:''.'",';
            $code .="\n";
            $code .='"below_div"=>"'.($field['hint'])?$field['hint']:''.'",';
            $code .="\n";
            $code .='"value"=>(array_key_exists("'.$field['name'].'",$data))?$data["'.$field['name'].'"]:old("'.$field['name'].'")';
            $code .="\n";
            $code .='],';
            $code .="\n";
        }elseif(in_array($field['type'],['date','date_time','time'])){

        }elseif(in_array($field['type'],['checkbox','radio_button'])){

        }elseif(in_array($field['type'],['text_area','text_editor'])){
            $code .='"'.$field['name'].'"=>[';
            $code .="\n";
            $code .='"input_type"=>"textarea",';
            $code .="\n";
            $code .='"attributes"=>["rows"=>4],';
            $code .="\n";
            $code .='"type"=>"'.$field['type'].'",';
            $code .="\n";
            $code .='"title"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .='"name"=>"'.$field['name'].'",';
            $code .="\n";
            $code .='"placeholder"=>"'.$field['show_as'].'",';
            $code .="\n";
            if($field['type']=='text_editor'){
                $code .='"class"=>"ckeditor",';
            }else{
                $code .='"class"=>"",';
            }
            $code .="\n";
            $code .='"around_div"=>"form-group form-md-line-input",';
            $code .="\n";
            $code .='"col"=>"'.($field['around_div'])?$field['around_div']:'col-md-12'.'",';
            $code .="\n";
            $code .='"below_div"=>"'.($field['hint'])?$field['hint']:''.'",';
            $code .="\n";
            $code .='"value"=>(array_key_exists("'.$field['name'].'",$data))?$data["'.$field['name'].'"]:old("'.$field['name'].'")';
            $code .="\n";
            $code .='],';
            $code .="\n";
        }elseif(in_array($field['type'],['image','multi_image','file','multi_file'])){
            $code .='"'.$field['name'].'"=>[';
            $code .="\n";
            $code .='"input_type"=>"upload_image",';
            $code .="\n";
            $code .='"type"=>"'.$field['type'].'",';
            $code .="\n";
            $code .='"title"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .='"name"=>"'.$field['name'].'",';
            $code .="\n";
            $code .='"placeholder"=>"",';
            $code .="\n";
            $code .='"class"=>"",';
            $code .="\n";
            $code .='"around_div"=>"form-group form-md-line-input",';
            $code .="\n";
            $code .='"col"=>"'.($field['around_div'])?$field['around_div']:''.'",';
            $code .="\n";
            $code .='"below_div"=>"'.($field['hint'])?$field['hint']:''.'",';
            $code .="\n";
            $code .='"value"=>(array_key_exists("'.$field['name'].'",$data))?readFileStorage($data["'.$field['name'].'"]):""';
            $code .="\n";
            $code .='],';
            $code .="\n";
        }elseif(in_array($field['type'],['record','video'])){
        }elseif(in_array($field['type'],['select','select_search','multi_select','multi_select_search'])){
            $options=[];
            $static=true;
            if(in_array($field['type'],['select','multi_select'])){
                $options_to_array=json_decode($field['fields_module'],true);

                $options=getOptions($options,$options_to_array);

            }elseif(in_array($field['type'],['multi_select_search','select_search'])){
                $options_to_array=json_decode($field['fields_module'],true);
                if(empty($options_to_array) && $field['related_with']!=''){
                    $static=false;
                }else{
                    $options=getOptions($options,$options_to_array);
                }
            }
            $code .='"'.$field['name'].'"=>[';
            $code .="\n";
            $code .='"input_type"=>"select",';
            $code .="\n";
            $code .='"type"=>"'.$field['type'].'",';
            $code .="\n";
            $code .='"title"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .='"name"=>"'.$field['name'].'",';
            $code .="\n";
            $code .='"placeholder"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .='"class"=>"select2_category",';
            $code .="\n";
            $code .='"around_div"=>"form-group form-md-line-input",';
            $code .="\n";
            $code .='"below_div"=>"'.($field['hint'])?$field['hint']:''.'",';
            $code .="\n";
            $code .='"col"=>"'.($field['around_div'])?$field['around_div']:''.'",';
            $code .="\n";
            if($static==false){
                $code .='"options"=>getValueByTableName("'.$field['related_with'].'",["name"],["is_active"=>0]),';
            }else{
                $code .='"options"=>[';
                    $code .="\n";
                    foreach($options as $key=>$value){
                        $code .='"'.$key.'"=>"'.$value.'",';
                        $code .="\n";
                    }
                $code .='],';
            }

            $code .="\n";
            $code .='"selected"=>(array_key_exists("'.$field['name'].'",$data))?$data["'.$field['name'].'"]:old("'.$field['name'].'")';
            $code .="\n";
            $code .='],';
            $code .="\n";
        }elseif(in_array($field['type'],['maps'])){
            $code .="\n";
            $code .='"'.$field['name'].'"=>[';
            $code .="\n";
            $code .='"input_type"=>"maps",';
            $code .="\n";
            $code .="\n";
            $code .='"title"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .='"name"=>"'.$field['name'].'",';
            $code .="\n";
            $code .='"placeholder"=>"'.$field['show_as'].'",';
            $code .="\n";
            $code .="\n";
            $code .='"around_div"=>"form-group form-md-line-input",';
            $code .="\n";
            $code .='"below_div"=>"'.($field['hint'])?$field['hint']:''.'",';
            $code .="\n";
            $code .='"value"=>(array_key_exists("'.$field['name'].'",$data))?$data["'.$field['name'].'"]:old("'.$field['name'].'")';
            $code .="\n";
            $code .='"lat_lon"=>(array_key_exists("lat_lon",$data))?$data["lat_lon"]:old("lat_lon")';
            $code .="\n";
            $code .='],';
            $code .="\n";
        }
        return $code;
    }
}
if(!function_exists('getOptions')){
    function getOptions($options,$options_to_array,$type='multi_select'){

        if($type=='multi_select'){
            $count=0;
            if(array_key_exists('order',$options_to_array)){
                foreach($options_to_array['order'] as $value){
                    $options[$options_to_array['name'][$count]]=$options_to_array['title'][$count];
                    $count++;
                }
            }

        }else{
            foreach($options_to_array as $value){
                $options[$value->id]=$value->$type;
            }
        }
        return $options;
    }
}

if(!function_exists('getValueByTableName')){
    function getValueByTableName($table_name,$select=[],$where=[],$joins=[],$return_query=false,$single=false,$deleted_at=false,$strings_concat=[]){
        $select_db=[$table_name.'.id'];
        foreach($select as $value){
            $select_db[]=$value;
        }
        $query=DB::table($table_name)->select($select_db);
        if(!empty($joins)){
            if(is_array($joins[0])){
                foreach($joins as $join){
                    $query=$query->join($join[0],$join[1],$join[2]);
                }
            }else{
                $query=$query->join($joins[0],$joins[1],$joins[2]);
            }

        }
        if(!empty($where)){
            foreach($where as $key=>$value){
                if(is_array($value)){
                    $query=$query->where($key,$value[0]);
                    unset($value[0]);
                    foreach($value as $val){
                        $query=$query->orWhere($key,$val);
                    }
                }else{
                    $query=$query->where($key,$value);
                }

            }
        }
        if($deleted_at){
            $query=$query->whereNull($table_name.'.deleted_at');
        }
        if($single){
            $query=$query->first();
        }else{
            $query=$query->get();
        }

        if($return_query){
            return $query->toArray();
        }
        if($single){
            $return=$query;
        }else{
            $return=[];
            foreach($query as $key=>$value){
                $string='';
                $count=1;
                foreach($select as $show){

                    if(str_contains($show, ' as ')){
                        $arr=explode(' ',$show);
                        $show=$arr[2];
                    }
                    if(str_contains($show, '.')){
                        $arr=explode('.',$show);
                        $show=$arr[1];
                    }
                    if(array_key_exists($show,$strings_concat)){
                        $string.=$strings_concat[$show].' '.$value->$show;
                    }else{
                        $string.=$value->$show;
                    }
                    if($count!=count($select)){
                        $string.=' - ';
                    }
                    $count++;
                }
                $return[$value->id]=$string;
            }
        }

        return $return;
    }
}

if(!function_exists('checkCrud')){
    function checkCrud($id='',$table=''){
        if($table=='' && $id==''){
            return false;
        }
        if($table!=''){
            $request['where'][]=['table_db'=>$table];
            $modules=app(ModuleInterface::class)->data($request);
            $id=$modules[0]->id;
        }
        $request=[];
        $request['where'][]=['is_active'=>1];
        $request['where'][]=['crud_with'=>$id];
        $modules=app(ModuleInterface::class)->data($request);
        if(count($modules) > 1){
            return false;
        }
        return $modules;
    }
}

if(!function_exists('selectedOption')){
    function selectedOption($select,$table_name,$main='',$id='',$where=[]){
        if(is_array($select)){
            $data=DB::table($table_name);
            $data=$data->where($main,$id);
            if(!empty($where)){
                foreach($where as $key=>$value){
                    $data=$data->where($key,$value);
                }
            }
            $data=$data->select($select)->get();
            $return=[];
            if($data){
                foreach($data as $value){
                    $arr=[];
                    foreach($select as $v){
                        if(in_array($v,['date','created_at','date_time'])){
                            $arr[$v]=date('Y-m-d H:i:s',strtotime($value->$v));
                        }else{
                            $arr[$v]=$value->$v;
                        }

                    }
                    $return[]=$arr;
                }
            }
        }else{
            if($main!='' && $id!=''){
                $data=DB::table($table_name)->where($main,$id)->get()->pluck($select);
                $return=[];
                if($data){
                    foreach($data as $value){
                        $return[]=$value;
                    }
                }
            }else{

                $return=DB::table($table_name)->get()->pluck($select,'id')->toArray();
            }
        }


        return $return;
    }
}
if(!function_exists('getPermissions')){
    function getPermissions($id='',$type='normal'){

        if($type=='normal'){
            if($id!=''){
                $module_and_permissions=DB::table('install_permission_moduel_roles')
                ->join('install_modules','install_permission_moduel_roles.module_id','install_modules.id')
                ->select('install_modules.name','install_permission_moduel_roles.module_id','install_permission_moduel_roles.permission_id')
                ->where('role_id',$id)->get();
            }else{
                $module_and_permissions=DB::table('install_permission_moduels')
                ->join('install_modules','install_permission_moduels.module_id','install_modules.id')
                ->select('install_modules.name','install_permission_moduels.module_id','install_permission_moduels.permission_id')
                ->get();
            }
            $permissions=[];
            foreach($module_and_permissions as $value){

                if(!array_key_exists($value->module_id,$permissions)){
                    $permissions[$value->module_id]=[
                        'module_id'=>$value->module_id,
                        'module_name'=>$value->name
                    ];
                    $permission_ids=$module_and_permissions->where('module_id',$value->module_id)->pluck('permission_id')->toArray();

                    if(!empty($permission_ids)){
                        $permission_names=DB::table('install_permissions')->whereIn('id',$permission_ids)->select('id','name')->get()->pluck('name','id')->toArray();
                        $permissions[$value->module_id]['permissions']=$permission_names;

                    }else{
                        unset($permissions[$value->module_id]);
                    }
                }
            }
        }elseif($type=='specific'){
            $permissions=[];
            $permissions=Role::where('id',$id)->first()->spasfice_permissions;

            if($permissions){
                return json_decode($permissions,true);
            }else{
                return [];
            }
        }elseif($type=='reports'){
            $permissions=[];
            $permissions=Role::where('id',$id)->first()->reports_permissions;

            if($permissions){
                return json_decode($permissions,true);
            }else{
                return [];
            }
        }elseif($type=='notifications'){
            $permissions=[];
            $permissions=Role::where('id',$id)->first()->notifications_permissions;

            if($permissions){
                return json_decode($permissions,true);
            }else{
                return [];
            }
        }

        return $permissions;

    }
}
if(!function_exists('getAdminIdsPerSpasficPermission')){
    function getAdminIdsPerSpasficPermission($permission){

        $admins=Admin::where('is_active',1)->get();
        $admins=Admin::transformCollection($admins,'Array');
        $ids=[];
        foreach($admins as $admin){
            $specific_permissions=json_decode($admin['specific_permissions'],true);
            if(in_array($permission,$specific_permissions)){
                $ids[]=$admin['id'];
            }
        }
        return $ids;
    }
}

if(!function_exists('checkAdminPermission')){
    function checkAdminPermission($permission_id,$module_id='',$type='normal'){
        if(auth()->guard('admin')->id()==1){
            return true;
        }
        if($type=='specific'){
            $permissions=auth()->guard('admin')->user()->role->spasfice_permissions;
            if($permissions){
                $permissions=json_decode($permissions,true);
                if(is_array($module_id)){
                    foreach($module_id as $module){
                        if(array_key_exists($module,$permissions)){
                            return true;
                        }
                    }
                }else{
                    if(array_key_exists($module_id,$permissions)){
                        return in_array($permission_id,$permissions[$module_id]);
                    }
                }

            }
        }elseif($type=='report'){

            $permissions=auth()->guard('admin')->user()->role->reports_permissions;
            if($permissions){
                $permissions=json_decode($permissions,true);

                if(is_array($module_id)){
                    foreach($module_id as $module){
                        if(array_key_exists($module,$permissions)){
                            return true;
                        }
                    }
                }else{
                    return in_array($module_id,$permissions);
                }

            }
        }else{

            $permission=[
                'insert'=>1,
                'update'=>2,
                'view'=>3,
                'show'=>4,
                'delete'=>5,
                'translate'=>6,
                'send_mail'=>7,
                'add_new_task'=>8,
            ];
            $data=auth()->guard('admin')
            ->user()
            ->role->permissions;
            if(is_array($module_id)){

                $data=$data->whereIn('module_id',$module_id);
            }else{
                $data=$data->where('module_id',$module_id);
            }

            $data=$data->where('permission_id',$permission[$permission_id])
            ->first();
            if($data){
                return $data;
            }else{
                return false;
            }
        }




    }
}
if(!function_exists('checkDebpartmentShow')){

    function checkDebpartmentShow($name){
        $moduels=getModulesFromGroup($name);
        $ids=array_column($moduels, 'id');
        $sub_departments = getDepartments(true,$name);
        foreach($sub_departments as $sub){
            $sub_modules = getModulesFromGroup($sub['name']);
            $ids=array_merge($ids,array_column($sub_modules, 'id'));
        }
        if(checkAdminPermission("view",$ids)){
            return true;
        }else{
            return false;
        }
    }

}

if(!function_exists('counterData')){
    function counterData($module=null,$report=null){

        $request=[];
        $request['whereNull']=['module_related'];
        $request['where'][]=['is_active'=>1];
        if($report){
            $request['where'][]=['report_related'=>$report];
        }else{
            $request['whereNull']=['report_related'];
        }

        $request['select']=['name','statement','prams_counters','type','icon','ordered'];
        $counters=app(CounterInterface::class)->data($request);

        $return=[];
        $sqls=[];
        $params=[];

        foreach($counters as $counter){
            $element=[];
            $sql=$counter->statement;
            $param=json_decode($counter->prams_counters,true);
            if($param['fields_type'][0]=='get_param'){
                if(array_key_exists($param['value'][0],$_GET)){
                    $param=[$_GET[$param['value'][0]]];
                }else{
                    continue;
                }
            }else{
                if($param['order'][0]==null){
                    $param=[];
                }
            }
            $sql_arr=explode('counter',$sql);
            $sql=$sql_arr[0].' counter, "'.$counter->name.'" as type '. $sql_arr[1];
            $sqls[]=$sql;

            $params=array_merge($params,$param);

            $element['number']=0;
            $element['icon']=$counter->icon;
            $element['title']=$counter->name;
            $element['order']=$counter->ordered;
            $return[]=$element;
        }
        //,DB::raw('"main_language" as type')]

        if(!empty($sqls)){
            $sqls=implode(' Union ',$sqls);
            $numbers = DB::select($sqls, $params);
            foreach($numbers as $key=>$value){
                $value->counter;
                if(array_key_exists($key,$return)){
                    $return[$key]['number']=$value->counter;
                }
            }
            $price = array_column($return, 'order');
            array_multisort($price, SORT_ASC, $return);
        }

        return $return;

    }
}

if(!function_exists('setPageHead')){
    function setPageHead($route,$main_title,$sub_title,$param,$another_title=''){
        if($route==''){
            return false;
        }
        $route=explode('.',$route);

        $config = [];
        $config["main_title"] = $main_title;

        $config["sub_title"] = $sub_title;
        $main_route=$route[0].'.index';
        $query_builder=[];
        if(!empty($_GET)){
            $query_builder=$_GET;
        }

        $breadcrumb=[];
        $breadcrumb[]=['title'=>$config["sub_title"],'route'=>$main_route,'params'=>[],'query_builder'=>$query_builder];
        // dd(request()->route()->parameters());
        if($route[1]!='index'){
            $main_route=$route[0].'.'.$route[1];

            if($route[1]=='show' ){

                $params=[];
                $params[$param]=request()->route()->parameter($param);
                $breadcrumb[]=['title'=>$config["sub_title"],'route'=>$main_route,'params'=>$params,'query_builder'=>$query_builder];

            }elseif($route[1]=='edit'){

                    $params=[];
                    $params[$param]=request()->route()->parameter($param);
                    $breadcrumb[]=['title'=>'Edit '.$config["sub_title"],'route'=>$main_route,'params'=>$params,'query_builder'=>$query_builder];

                }elseif($route[1]=='translate'){
                $params=[];
                $params[$param]=request()->route()->parameter('id');
                $breadcrumb[]=['title'=>'Edit '.$config["sub_title"].' '.$another_title,'route'=>$route[0].'.show','params'=>$params,'query_builder'=>$query_builder];
                $params=[];
                $params['id']=request()->route()->parameter('id');
                $breadcrumb[]=['title'=>ucfirst($route[1]).' '.$another_title,'route'=>$main_route,'params'=>$params,'query_builder'=>$query_builder];
            }else{

                $breadcrumb[]=['title'=>ucfirst($route[1]).' '.$config["sub_title"],'route'=>$main_route,'query_builder'=>$query_builder];
            }

            // $config["sub_title"] = ucfirst($route[1])." City" ;
        }

        $config["breadcrumb"] =$breadcrumb;
       return $config;
    }
}

if(!function_exists('storeLogs')){
    function storeLogs($table_name,$post_id,$action,$old_data=[],$new_data=[]){
        return true;
        if(auth()->guard('admin')->check()){
            $admin_id=auth()->guard('admin')->user()->id;
            $data=[];
            $data['admin_id']=$admin_id;
            $data['table_name']=$table_name;
            $data['post_id']=$post_id;
            $data['action']=$action;
            $data['old_data']=json_encode($old_data);
            $data['new_data']=json_encode($new_data);
            DB::table('install_logs')->insert($data);
        }

        return true;
    }

}

if(!function_exists('randomNumber')){
    function randomNumber($length=8,$id=false,$start_with=false) {
        $random = "";
        $data = "123456123456789071234567890890";
        for ($i = 0; $i < $length; $i++) {
                $random .= substr($data, (rand() % (strlen($data))), 1);
        }
        if($start_with)
            $num=$start_with.date('YmdHis').$random;
        else
            $num='#'.date('YmdHis').$random;
        if($id){
            $num=$num.$id;
        }
        return $num;

    }
}

if(!function_exists('reportsLinks')){
    function reportsLinks($type="left_side",$text_align='left',$id='') {

        $arr=[
            'is_active'=>1,
            'show_in'=>$type,
            'text_align'=>$text_align
        ];
        if($id!=''){
           $arr['with_report']=$id;
        }

        return getValueByTableName('install_reports',['name'],$arr);
    }
}
if(!function_exists('homePageReport')){
    function homePageReport($id,$with_body=true){
        $data=app(ReportInterface::class)->data([],$id);
        $main_table=$data['table_db'];
        $joins=json_decode($data['db_joins'],true);
        $condtions=json_decode($data['db_condtions'],true);
        $selects=json_decode($data['db_select'],true);
        $orders=json_decode($data['report_order_by'],true);
        $addtional=json_decode($data['report_addtinal_filter'],true);
        $limits=$data['limit'];
        $groups_by=$data['group_by'];
        $query=app(ReportInterface::class)->build_query($main_table,$selects,$joins,$condtions,$groups_by,$orders,$limits,request()->all());
        $table=[];
        $table['head']=$selects['show_as'];
        if($with_body){
            $table['body']= DB::select($query);
        }else{
            $table['body']= [];
        }
        return $table;
    }
}


if(!function_exists('dbApi')){
    function dbApi(){
        $data=DB::table('install_api')->get();
        $return=[];
        foreach($data as $value){
            $arr=[];
            $arr['id']=$value->id;
            $arr['name']=$value->name;
            $arr['route_name']=route($value->route_name);
            $arr['type']=$value->type;
            $arr['created_at']=date('Y-m-d H:i:s',strtotime($value->created_at));;
            $return[]=$arr;
        }
        return $return;
    }
}


function getBadge($badge_id){
    $count=0;
    $Badge=Notification::where('is_active',1)
    ->where('id',$badge_id)
    ->first();
    if($Badge){
        $count = DB::table($Badge->table_db)
        ->where($Badge->field_name,$Badge->field_value)
        ->count();
    }
    return $count;
}
function changeBadgeStatus($badge_id){
    $Badge=Notification::where('is_active',1)
    ->where('id',$badge_id)
    ->first();
    if($Badge){
        DB::table($Badge->table_db)
        ->where($Badge->field_name,$Badge->field_value)
        ->update([
            $Badge->field_name=>NotificationEnum::SHOW
        ]);
    }
}
function getNotifications($type=''){
    $data=[];
    if($type==''){
        $Notification=Notification::where('is_active',1)
        ->where('type',NotificationTypeEnum::NOTIFICATION)
        ->get();
        if($Notification){
            $Notification=Notification::transformCollection($Notification,'Array');
            foreach($Notification as $Noti){
                $row=[];
                $row['id']=$Noti['id'];
                $row['name']=$Noti['name'];
                $row['icon']=$Noti['icon'];
                $row['message']=$Noti['message'];
                $row['count']=DB::table('install_notifiable')
                ->where('notification_id',$Noti['id'])
                ->where('status',NotificationEnum::NEW)

                ->count();
                $data[]=$row;
            }
        }
    }else{
        $data=DB::table('install_notifiable')
        ->where('notification_id',$type)
        ->where('status',NotificationEnum::NEW)
        ->get();
    }
    return $data;
}
function ChangeNotificationStatus($id){

    DB::table('install_notifiable')
    ->where('id',$id)
    ->where('status',NotificationEnum::NEW)
    ->update(['status'=>NotificationEnum::SHOW]);
    return true;
}




?>
