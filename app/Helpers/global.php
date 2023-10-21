<?php
use App\Exports\DataExport;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\setting_management\CodeInterface;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\setting_management\GeneralInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;

//////////// Start Files And Images
if(!function_exists('uploadImage')){
    function uploadImage($image, $folder = '', $base64 = false, $file_name = '',$is_file=false)
    {

        $request=request();
        $encode=100;
        if($is_file){
            $files = $request->file($image);
            if(!is_array($files)){
                $ext = $files->getClientOriginalExtension();
                if($is_file==true || $ext=='svg'){
                    if($folder!=''){
                        if (!File::exists(storage_path('/app/uploads/'.$folder))) {
                            File::makeDirectory(storage_path('/app/uploads/'.$folder), 0755, true, true);
                        }
                    }

                    $files = $request->file($image_file);
                    $fileName = time() . '.' . $files->getClientOriginalExtension();
                    $files->move(storage_path('/app/uploads/'.$folder), $fileName);
                    return $folder.'/'.$fileName;
                }
            }
        }
        $ext='webp';
        if (!$base64) {
            // if ($request->file($image_file)->isValid()) {
            // $image = $request->file($image_file);
            if (is_array($image)) {
                $files=[];
                $count = 1;
                foreach ($image as $file) {
                    // $filename = time() . $count . '.' . $file->getClientOriginalExtension();
                    $filename = time() . $count . '.'.$ext;

                    if (!File::exists(storage_path('/app/uploads'))) {
                        File::makeDirectory(storage_path('/app/uploads'), 0755, true, true);
                        File::makeDirectory(storage_path('/app/uploads/small'), 0755, true, true);

                    }
                    if($folder!=''){
                        if (!File::exists(storage_path('/app/uploads/'.$folder))) {
                            File::makeDirectory(storage_path('/app/uploads/'.$folder), 0755, true, true);
                            File::makeDirectory(storage_path('/app/uploads/'.$folder.'/small'), 0755, true, true);

                        }
                        $path = storage_path('/app/uploads/'.$folder.'/'. $filename);
                        $path_small = storage_path('/app/uploads/'.$folder .'/small/'. $filename);
                    }else{
                        $path = storage_path('/app/uploads/'. $filename);
                        $path_small = storage_path('/app/uploads/small/'. $filename);
                    }


                    Image::make($file->getRealPath())->save($path,70);
                    // Image::make($file->getRealPath())->resize(200, 200)->save($path,70);
                    if($folder!=''){
                        $files[] = $folder.'/'.$filename;
                    }else{
                        $files[] = $filename;
                    }

                    ++$count;
                }

                return json_encode($files);
            } else {

                if ($file_name == '') {
                    // $filename = time() . '.' . $image->getClientOriginalExtension();
                    // $filename = time() . '.'.$ext;
                    $filename = time(). '.'.$ext;
                } else {

                    // $filename = $file_name . time() . '.png';
                    $filename = $file_name. '.'.$ext;
                }
                if (!File::exists(storage_path('/app/uploads'))) {
                    File::makeDirectory(storage_path('/app/uploads'), 0755, true, true);
                    // File::makeDirectory(storage_path('/app/uploads/small'), 0755, true, true);
                }

                if($folder!=''){
                    if (!File::exists(storage_path('/app/uploads/'.$folder))) {
                        File::makeDirectory(storage_path('/app/uploads/'.$folder), 0755, true, true);
                        // File::makeDirectory(storage_path('/app/uploads/'.$folder.'/small'), 0755, true, true);

                    }
                    $path = storage_path('/app/uploads/'.$folder.'/'. $filename);
                    // $path_small = storage_path('/app/uploads/'.$folder .'/small/'. $filename);
                }else{
                    $path = storage_path('/app/uploads/'. $filename);
                    // $path_small = storage_path('/app/uploads/small/'. $filename);
                }

                Image::make($image->getRealPath())->save($path,70);
                // Image::make($image->getRealPath())->resize(200, 200)->save($path_small,70);
                if($folder!=''){
                    return $folder.'/'.$filename;
                }else{
                    return $filename;
                }
            }
            // }
        } else {

            $image = $request->$image_file;
            // $filename = time() . '.' . $image->getClientOriginalExtension();
            $filename = time() . '.'.$ext;
            if (!File::exists(storage_path('/app/uploads'))) {
                File::makeDirectory(storage_path('/app/uploads'), 0755, true, true);
                File::makeDirectory(storage_path('/app/uploads/small'), 0755, true, true);
            }
            if($folder!=''){
                if (!File::exists(storage_path('/app/uploads/'.$folder))) {
                    File::makeDirectory(storage_path('/app/uploads/'.$folder), 0755, true, true);
                    File::makeDirectory(storage_path('/app/uploads/'.$folder.'/small'), 0755, true, true);
                }
                $path = storage_path('/app/uploads/'.$folder.'/'. $filename);
                $path_small = storage_path('/app/uploads/'.$folder .'/small/'. $filename);
            }else{
                $path = storage_path('/app/uploads/'. $filename);
                $path_small = storage_path('/app/uploads/small/'. $filename);
            }
            Image::make(file_get_contents($image))->encode($ext, $encode)->save($path,$encode);
            Image::make(file_get_contents($image))->resize(200, 200)->encode($ext, $encode)->save($path_small,$encode);

            if($folder!=''){
                return $folder.'/'.$filename;
            }else{
                return $filename;
            }
        }
        return false;
    }
}
if(!function_exists('uploadFile')){
    function uploadFile($file, $folder = ''){
        if($folder!=''){
            if (!File::exists(storage_path('/app/uploads/'.$folder))) {
                File::makeDirectory(storage_path('/app/uploads/'.$folder), 0755, true, true);
            }
        }
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('/app/uploads/'.$folder), $fileName);
        return $folder.'/'.$fileName;
    }
}
if(!function_exists('readFileStorage')){
    function readFileStorage($file,$array=false){

        if($array){
            $images=json_decode($file,true);

            $images_return=[];
            if(is_array($images)){
                foreach($images as $img){
                    $main_path=storage_path('/app/uploads');
                    if (File::exists($main_path.'/'.$img)) {
                        $images_return[]=str_replace('/public', '', env('APP_FILES_URL')).'storage/app/uploads/'.$img;
                    }else{
                        $images_return[]=str_replace('/public', '', env('APP_FILES_URL')).'storage/app/uploads/notFound.png';
                    }
                }
            }
            return $images_return;
        }else{
            $main_path=storage_path('/app/uploads');
            if($file){
                if (File::exists(storage_path('/app/uploads').'/'.$file)) {

                    $path=str_replace('/public', '', env('APP_URL')).'storage/app/uploads/'.$file;

                }else{

                    $path=str_replace('/public', '', env('APP_URL')).'storage/app/uploads/notFound.png';
                }
            }else{
                $path=str_replace('/public', '', env('APP_URL')).'storage/app/uploads/notFound.png';
            }

            return $path;
        }

    }

}
if(!function_exists('deleteFileStorage')){
    function deleteFileStorage($file,$array=false){
        if($file){
            if($array){
                $images=json_decode($file,true);
                foreach($images as $img){
                    $path=storage_path('app/uploads/'.$img);
                    if($img=='notFound.png'){
                        continue;
                    }
                    if (File::exists($path)) {
                        unlink($path);
                    }
                }
            }else{
                if($file=='notFound.png'){
                    return true;
                }
                $path=storage_path('app/uploads/'.$file);
                if (File::exists($path)) {
                    unlink($path);
                }
            }

        }
        return true;

    }
}

if(!function_exists('handel_request_and_upload_file')){
    function handel_request_and_upload_file ($request,$image,$image_name,$id ='' ,$old_image =''){
        if (array_key_exists($image_name, $request)) {

            $return = $image;
            if ($id != "") {
                if (array_key_exists($image_name . "_removed", $request)) {

                    $old_image      = json_decode($old_image, true);
                    $removed_images = $request[$image_name . "_removed"];

                    if ($removed_images) {
                        $removed_images = explode(",", $removed_images);

                        foreach ($removed_images as $val) {

                            if (in_array($val, $old_image)) {

                                deleteFileStorage($val);
                                $key = array_search($val, $old_image);
                                unset($old_image[$key]);
                            }

                        }
                    }
                    $new_image            = json_decode($request[$image_name], true);
                    $all_images           = array_merge($old_image, $new_image);
                    $return               = json_encode($all_images);

                } else
                    deleteFileStorage($old_image);
            }
        } else {
            $return = "";
            if ($id != "") {

                if (array_key_exists($image_name . "_removed", $request)) {

                    $removed_images = $request[$image_name . "_removed"];
                    $old_image      = json_decode($old_image, true);

                    if ($removed_images) {
                        $removed_images = explode(",", $removed_images);

                        foreach ($removed_images as $val) {
                            if (in_array($val, $old_image)) {
                                deleteFileStorage($val);
                                $key = array_search($val, $old_image);
                                unset($old_image[$key]);
                            }
                        }
                    }
                    $old_image = json_encode($old_image);
                }
                $return = $old_image;
            }
        }
        return $return;
    }
}


//////////// End Files And Images

/////////// Start DataBase

if(!function_exists('StatementDB')){
    function StatementDB($data,$request,$query_builder=true,$count=false){

        if(array_key_exists('where',$request) && !empty($request['where'])){

            foreach($request['where'] as $wheres){
                foreach($wheres as $key=>$value){
                    $data=$data->where($key,$value);
                }
            }
        }
        if(array_key_exists('whereNotEqual',$request) && !empty($request['whereNotEqual'])){

            foreach($request['whereNotEqual'] as $wheres){
                foreach($wheres as $key=>$value){
                    $data=$data->where($key,'<>',$value);
                }
            }
        }
        if(array_key_exists('orWhere',$request) && !empty($request['orWhere'])){
            foreach($request['orWhere'] as $orWheres){
                foreach($orWheres as $key=>$value){
                    $data=$data->orWhere($key,$value);
                }
            }
        }
        if(array_key_exists('whereNotNull',$request) && !empty($request['whereNotNull'])){
            foreach($request['whereNotNull'] as $whereNotNull){
                $data=$data->whereNotNull($whereNotNull);
            }
        }
        if(array_key_exists('whereNull',$request) && !empty($request['whereNull'])){
            foreach($request['whereNull'] as $whereNotNull){
                $data=$data->whereNull($whereNotNull);
            }
        }
        if(array_key_exists('whereIn',$request) && !empty($request['whereIn'])){

            foreach($request['whereIn'] as $whereIn){

                foreach($whereIn as $key=>$value){
                    $data=$data->whereIn($key,$value);
                }
            }
        }
        if(array_key_exists('whereNotIn',$request) && !empty($request['whereNotIn'])){

            foreach($request['whereNotIn'] as $whereNotIn){

                foreach($whereNotIn as $key=>$value){

                    $data=$data->whereNotIn($key,$value);
                }
            }
        }
        if(array_key_exists('orderBy',$request)){
            foreach($request['orderBy'] as $key=>$value){
                $data=$data->orderBy($key,$value);
            }
        }
        if(array_key_exists('whereDate',$request) && $request['whereDate']!=''){
            foreach($request['whereDate'] as $value){
                $data=$data->whereDate($value[0],$value[1],$value[2]);
            }

        }
        if(array_key_exists('whereLike',$request) && !empty($request['whereLike'])){
            foreach($request['whereLike'] as $wheres){
                foreach($wheres as $key=>$value){
                    $data=$data->where($key,'like','%'.$value.'%');
                }
            }
        }

        if(array_key_exists('with',$request) && !empty($request['with'])){
            $data=$data->with($request['with']);
        }
        if($query_builder){
            if(array_key_exists('select',$request) && !empty($request['select'])){
                $request['select'][]='id';
                $data=$data->select($request['select']);
            }
        }
        if ($query_builder) {
            if (array_key_exists('row_in_page', $request) && !empty($request['row_in_page'])) {
                $data = $data->limit($request['row_in_page']);
            }
        }

        if(array_key_exists('offset',$request) && !empty($request['offset'])){
            $data=$data->offset($request['offset']);
        }

        if($count){
            $data=$data->count();
        }
        return $data;
    }
}

if(!function_exists('SetStatementDB')){
    function SetStatementDB($request,$filters,$exptiedLike=[]){

        if(array_key_exists("created_from",$filters) && $filters["created_from"]!=null){
            $request["whereDate"][]=["created_at",">=",$filters["created_from"]];
        }
        if(array_key_exists("created_to",$filters) && $filters["created_to"]!=""){
            $request["whereDate"][]=["created_at","<=",$filters["created_to"]];
        }
        unset($filters["created_from"]);
        unset($filters["created_to"]);
        unset($filters["page"]);

        if(array_key_exists("row_in_page",$filters) && $filters["row_in_page"]!=''){
            $request["row_in_page"]=$filters["row_in_page"];
        }else{
            $request["row_in_page"]=config('var.rows_table_count');
        }
        unset($filters["row_in_page"]);
        unset($filters["main_id"]);
        if(!empty($filters)){
            foreach($filters as $key=>$filter){
                if($filter!=""){
                    if(is_numeric($filter) || in_array($key,$exptiedLike)){
                        $request["where"][]=[$key=>$filter];
                    }else{
                        $request["whereLike"][]=[$key=>$filter];
                    }

                }
            }
        }
        return $request;
    }
}


/////////// End DataBase

/////////// Start Language

if(!function_exists('appendToLanguage')){
    function appendToLanguage($language,$file,$word){
        $language_interface=app(LanguageInterface::class);
        $folder_path=base_path().'/resources/lang/'.$language;
        if (! File::exists($folder_path)) {
            $language_interface->set_language($language);
        }

        $language_interface->check_word_exists($language,$file,$word);

        app()->setLocale($language);
        $translate=__($file.'.'.$word);
        return $translate;
    }
}
if(!function_exists('getMainLanguage')){
    function getMainLanguage(){
        if(!session()->has('main_lang')){
            $language_interface=app(LanguageInterface::class);
            $request=[];
            $request['where'][]=['is_main'=>1];
            $request['select']=['slug'];
            $request['row_in_page']=1;
            $main_lang=$language_interface->data($request);
            session(['main_lang'=>$main_lang[0]->slug]);
        }

        return session()->get('main_lang');


    }
}

if(!function_exists('getDashboardCurrantLanguage')){
    function getDashboardCurrantLanguage(){
        if(!session()->has('language_dashboard')){
            return getMainLanguage();
        }
        return session()->get('language_dashboard');
    }
}


/////////// End Language
if(!function_exists('download_excel')){
    function download_excel($interfaces,$filters){
        return Excel::download(new DataExport($interfaces,$filters), 'users.xlsx');
     }
}



//////// Start Codes
if(!function_exists('getCodes')){
    function getCodes($id='',$options=true,$info=false){
        $request=[];
        if($info==true){
            $request['where'][]=['id'=>$id];
        }else{
            if($id!=''){
                $request['where'][]=['code_id'=>$id];
            }else{
                $request['whereNull'][]=['code_id'];
            }
        }


        if($options==true){
            $request['select']=['id','name'];
        }

        $request['row_in_page']=10000;
        $codes=app(CodeInterface::class)->data($request);
        if($options==true){
            $codes=getOptions([],$codes,'name');
        }

        return $codes;
    }
}
if(!function_exists('getCodesAjax')){
    function getCodesAjax($id,$value=''){
        $data=getCodes($id);
        $title='';
        if(!empty($data)){
            $title=getCodes($id,false)[0]->parent->sub_title;
        }

        if(empty($data)){
            return '';
        }
        $selected='';
        if($value!=''){
           $values=json_decode($value);
            foreach(array_keys($data) as $code){
                if(in_array($code,$values)){
                    $selected=$code;
                }
            }
        }
        $fields=[
            'input_type'=>'select',
            'type'=>'select',
            'title'=>$title,
            'name'=>'codes[]',
            'placeholder'=>'Choose',
            'class'=>'select codeRelated childe'.$id,
            'around_div'=>'form-group form-md-line-input',
            'attributes'=>['id'=>1],
            'col'=>'',
            'below_div'=>'',
            'options'=>$data,
            'selected'=>$selected,
        ];
        $html=viewComponents('select',$fields);
        return $html;
    }
}
if(!function_exists('changeStageTasksAjax')){
    function changeStageTasksAjax($stage,$task){
        DB::table('install_tasks')->where('id',$task)->update(['status'=>$stage]);
        return true;
    }
}
if(!function_exists('changeStatusClientAjax')){
    function changeStatusClientAjax($status,$client){
        DB::table('osoule_clients')->where('id',$client)->update(['status'=>$status]);
        return true;
    }
}

//////// End Codes

//////// Start App Setting
if(!function_exists('appSettings')){
    function appSettings($key){
        $data=app(GeneralInterface::class)->data($key);
        return $data;
    }
}

//////// End Setting

//////// Start Api Handling
if(!function_exists('requestHandling')){
    function requestHandling($request,$module_id){
        $page=1;
        if(array_key_exists('page',$request->all())){
            $page=$request->page;
        }
        // $records_count = app(CitiesInterface::class)->model->count();
        $request=SetStatementDB([],$request->all());
        $request['page']=$page;
        $offset = ($page * $request["row_in_page"]) - $request["row_in_page"];
        // $pagination = (int)ceil($records_count / $request["row_in_page"]);
        $request['offset']=$offset;
        $request['select']=['id'];
        $module=app(ModuleInterface::class)->data([],$module_id);

        foreach($module['fields'] as $field){
            if($field->related_with!=''){
                $request['with']=[explode('_',$field->related_with)[1]];
            }
            $actions=json_decode($field->fields_action,true);
            if(in_array(5,$actions)){
                $request['select'][]=$field->name;
            }

        }
        return $request;

    }
}


if(!function_exists('return_handling')){
    function return_handling($error,$message,$data,$passing_data=[],$array_defult=true,$shape=1){
        if($shape==1){
            return api_shape_1($error,$message,$data,$passing_data,$array_defult);
        }else{
            return api_shape_2($error,$message,$data,$passing_data,$array_defult);
        }

    }
}
if(!function_exists('api_shape_1')){
    function api_shape_1($error,$message,$data,$passing_data=[],$array_defult=true){
        $return=[];
        $return['error']=$error['check'];
        $lang=checkLanguage();
        $message=appendToLanguage($lang,'validations',$message);
        if($error['check']==true){
            $return['message']=$message;
        }else{
            $return['message']=$message;
        }

        $arr=[];
        if($data==null){
            if($array_defult){
                $arr['item']=[];
            }else{
                $arr['item']=new stdClass();
            }
        }else{

            if(is_array($data)){
                if(array_key_exists(0,$data)){
                    $arr['item']=$data;
                }else{
                    $arr=$data;
                }

            }else{
                $arr=$data;
            }

        }
        if(!empty($passing_data)){
            // $return['passing_data']=[];
            foreach($passing_data as $key=>$value){
                $arr[$key]=$value;
            }
        }
        $return['data']=$arr;

        return $return;
    }
}
if(!function_exists('api_shape_2')){
    function api_shape_2($error,$message,$data,$passing_data=[],$array_defult=true){
        $return=[];
        $return['error']=$error['check'];
        if($error['check']==true){
            $return['error_messages']=$error['messages'];
        }
        $return['message']=$message;
        $arr=[];
        if($data==null){
            if($array_defult){
                $arr['item']=[];
            }else{
                $arr['item']=new stdClass();
            }
        }else{
            $arr['item']=$data;
        }
        if(!empty($passing_data)){
            // $return['passing_data']=[];
            foreach($passing_data as $key=>$value){
                $arr[$key]=$value;
            }
        }
        $return['data']=$arr;

        return $return;
    }
}


//////// End Api Handling



if(!function_exists('convertToArray')){
    function convertToArray($item,$main,$subs=[],$tow_dimintion=true){
        $array_combine=json_decode($item,true);

        if($array_combine){
            $array=[];
            foreach($array_combine[$main] as $key=>$value){

                if($tow_dimintion){
                    $arr=[];
                    $arr[$main]=$array_combine[$main][$key];
                    $arr[$subs[0]]=$array_combine[$subs[0]][$key];
                    $array[]=$arr;
                }else{
                    $array[$array_combine[$main][$key]]=$array_combine[$subs[0]][$key];
                }

            }
            return $array;
            if(array_key_exists($main,$array_combine)){
                foreach($subs as $value){
                    $array_combine=array_combine($array_combine[$main],$array_combine[$value]);
                }
            }
        }else{
            $array_combine=[];
        }
        return $array_combine;
    }
}

if(!function_exists('clearCash')){
    function clearCash(){
        Artisan::call('cache:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:cache');
        Artisan::call('cache:clear');
        return true;
   }
}

function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d' , $without =[] ) {

    $dates = array();
    $current = strtotime($first);
    $last = strtotime($last);

    while( $current <= $last ) {

        $date  = date('D', $current);
        if(!in_array($date , $without)){
            $dates[] = date($output_format, $current);
        }
        $current = strtotime($step, $current);
    }

    return $dates;
}

////////////////// End Notification






?>
