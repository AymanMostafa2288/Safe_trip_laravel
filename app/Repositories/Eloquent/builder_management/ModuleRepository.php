<?php
namespace App\Repositories\Eloquent\builder_management;

use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Repositories\Interfaces\setting_management\GeneralInterface;
use App\Models\Module;
use Exception;
use File;
use DB;
use Artisan;

class ModuleRepository implements ModuleInterface
{
    public $model;
    public $files=[];

    public function __construct(Module $model)
    {
        $this->model = $model;
    }
    public function data($request=[],$id='*',$field_name='',$re_session=false){
        if(appSettings('app_mode')=='maintenance' || appSettings('app_mode')=='development'){
            $data=$this->model->all();
            session(['all_module_backend'=>$data]);
        }


        if($re_session){
            $data=$this->model->all();
            session(['all_module_backend'=>$data]);
        }
        if(!session()->has('all_module_backend')){
            $data=$this->model->all();
            session(['all_module_backend'=>$data]);
        }
        $data=session()->get('all_module_backend');

        if($id=='*'){
            $data=StatementDB($data,$request,false);
            // $data=$data->get();
            if(array_key_exists('select',$request)){
                $data=$this->model->transformCollection($data,'Custom',false,false,$request['select']);
            }else{
                $data=$this->model->transformCollection($data);
            }
        }else{
            if(!empty($request) && array_key_exists('with',$request)){

                $data=$this->model;
            }
            $data=StatementDB($data,$request, false);

            $data=$data->where('id',$id);
            $data=$data->first();

            $data=$this->model->transformArray($data);
            if($field_name!=''){
                $data=$data[$field_name];
            }
        }
        return $data;
    }
    public function store($request){
        try{
            unset($request['_token']);
            $request['departments_module']=json_encode($request['departments_module']);

            if(array_key_exists('fields_action',$request)){
                $request['fields_action']=json_encode($request['fields_action']);
            }



            $data=$this->model->create($request);
            if(array_key_exists('module_permissions',$request)){
                $rows=[];
                foreach($request['module_permissions'] as $permission){
                    $rows[]=['module_id'=>$data->id,'permission_id'=>$permission];
                }
                DB::table('install_permission_moduels')->insert($rows);
            }
            return $data;
        }catch(Exception $e){
            dd($e);
            return false;
        }
    }
    public function update($request,$id){
        try{
            unset($request['_token']);
            $data=$this->model->find($id);
            $data->name=$request['name'];
            $data->is_active=$request['is_active'];
            $data->show_in_left_side=$request['show_in_left_side'];
            $data->table_db=$request['table_db'];
            $data->departments_module=json_encode($request['departments_module']);
            $data->fields_action=json_encode($request['fields_action']);
            $data->crud_with=$request['crud_with'];
            $data->with_group=$request['with_group'];
            $data->name_repo=$request['name_repo'];
            $data->folder_repo=$request['folder_repo'];
            $data->model_repo=$request['model_repo'];
            $data->route_repo=$request['route_repo'];
            $data->controller_repo=$request['controller_repo'];


            $data->save();
            if(array_key_exists('module_permissions',$request)){
                $rows=[];
                foreach($request['module_permissions'] as $permission){
                    $rows[]=['module_id'=>$data->id,'permission_id'=>$permission];
                }
                DB::table('install_permission_moduels')->where('module_id',$data->id)->delete();
                DB::table('install_permission_moduels')->insert($rows);
            }
            return $data;
        }catch(Exception $e){
            return false;
        }
    }

    public function delete($id){
        try{
            $data=$this->model->find($id);
            $data->delete();
        }catch(Exception $e){
            dd($e);
            return false;
        }

    }



    public function create_repository_structures($name,$folder_name,$model_name,$route_name,$controller_name,$module_id){

        $repo_name=$name.'Repository';
        $interface_name=$name.'Interface';
        $controller_name=$controller_name.'Controller';
        $view_name=strtoLower($model_name);
        $module=app(ModuleInterface::class)->data([],$module_id,'',true);
        $DB_table_name=$module['table_db'];

        $path = base_path() . '/app/Repositories/Eloquent/custom_modules_management/'.$folder_name.'/'.$repo_name.'.php';

        if (!file_exists($path)) {

            $this->folders_check_and_create($folder_name);
            $this->create_interface($folder_name,$interface_name);
            $this->create_repository($folder_name,$repo_name,$interface_name,$model_name,$module_id);
            $this->change_service_provider($folder_name,$repo_name,$interface_name);
            $this->create_model($model_name,$DB_table_name,$module_id);
            $this->create_controller($folder_name,$controller_name,$interface_name,$route_name,$view_name,$model_name);
            $this->create_request($folder_name,$model_name,$module_id,$DB_table_name);
            $this->create_routes($folder_name,$route_name,$controller_name);
            $this->create_table_design($folder_name,$view_name,$route_name,$interface_name,$module_id);
            $this->create_form_design($folder_name,$route_name,$view_name,$interface_name,$module_id);
        }
    }
    public function delete_repository_structures($name,$folder_name,$model_name,$route_name,$controller_name,$module_id){

        $repo_name=$name.'Repository';
        $interface_name=$name.'Interface';
        $controller_name=$controller_name.'Controller';
        $DB_table_name=env('DB_SUFFIX').$route_name;
        $view_name=strtoLower($model_name);

        $data=$this->model->find($module_id);
        $data->is_active=0;
        $data->save();
        //Interface
        $path = base_path() . '/app/Repositories/Interfaces/custom_modules_management/'.$folder_name.'/'.$interface_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Eloquent
        $path = base_path() . '/app/Repositories/Eloquent/custom_modules_management/'.$folder_name.'/'.$repo_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Model
        $path = base_path() . '/app/Models/CustomModels/'.$model_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Controller
        $path = base_path() . '/app/Http/Controllers/backend/custom_modules_management/'.$folder_name.'/'.$controller_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Table View
        $path = base_path() . '/app/Tables/custom_modules_management/'.$folder_name.'/'.$view_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Form View
        $path = base_path() . '/app/Forms/custom_modules_management/'.$folder_name.'/'.$view_name.'.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Request Store
        $path = base_path() . '/app/Http/Requests/backend/custom_modules_management/'.$folder_name.'/Store'.$model_name.'Request.php';
        if (File::exists($path)) {
            unlink($path);
        }
        //Request Edit
        $path = base_path() . '/app/Http/Requests/backend/custom_modules_management/'.$folder_name.'/Edit'.$model_name.'Request.php';
        if (File::exists($path)) {
            unlink($path);
        }

    }



    // Start Global Functions
    private function folders_check_and_create($folder_name){
        $folder_path=base_path() . '/app/Repositories/Eloquent/custom_modules_management/'.$folder_name;
        $folder_path_interface = base_path() . '/app/Repositories/Interfaces/custom_modules_management/'.$folder_name;
        $folder_path_controller = base_path() . '/app/Http/Controllers/backend/custom_modules_management/'.$folder_name;
        $folder_path_table_design = base_path() . '/app/Tables/custom_modules_management/'.$folder_name;
        $folder_path_form_design = base_path() . '/app/Forms/custom_modules_management/'.$folder_name;
        $folder_path_request = base_path() . '/app/Http/Requests/backend/custom_modules_management/'.$folder_name;
        if (! File::exists($folder_path)) {
            File::makeDirectory($folder_path);
        }
        if (! File::exists($folder_path_interface)) {
            File::makeDirectory($folder_path_interface);
        }
        if (! File::exists($folder_path_controller)) {
            File::makeDirectory($folder_path_controller);
        }
        if (! File::exists($folder_path_table_design)) {
            File::makeDirectory($folder_path_table_design);
        }
        if (! File::exists($folder_path_form_design)) {
            File::makeDirectory($folder_path_form_design);
        }
        if (! File::exists($folder_path_request)) {
            File::makeDirectory($folder_path_request);
        }
        return true;
    }
    private function change_service_provider($folder_name,$repo_name,$interface_name){

        $path = app_path() . '/Providers/RepositoryServiceProvider.php';
        $file   = file($path);

        $new_file=[];
        foreach ($file as $key=>$value){
            $new_file[]=$value;

            if($value=="//put Here singleton Path\n" || $value=="//put Here singleton Path\r\n"){

                $new_file[]="\n";
                $new_file[]="use App\Repositories\Interfaces\custom_modules_management\\".$folder_name."\\".$interface_name.";";
                $new_file[]="\n";
                $new_file[]="use App\Repositories\Eloquent\custom_modules_management\\".$folder_name."\\".$repo_name.";";
                $new_file[]="\n";
                $new_file[]="\n";
            }elseif($value=="//put Here singleton\n" || $value=="//put Here singleton\r\n"){
                $new_file[]="\n";
                $new_file[]="\$this->app->singleton(".$interface_name."::class, ".$repo_name."::class);";
                $new_file[]="\n";
            }
        }
        file_put_contents($path, $new_file);
        return true;
    }
    private function create_routes($folder_name,$route_name,$controller_name){

        $path = base_path() . '/routes/dashboard.php';
        $file   = file($path);
        $new_file=[];
        foreach ($file as $key=>$value){
            $new_file[]=$value;

            //Route::prefix('database')->namespace('database_management')->group(function () {
            if($value=="//route dynamic here\n" || $value=="//route dynamic here\r\n"){

                $new_file[]="\n";
                $new_file[]="Route::delete('".$route_name."/delete_all', '".$folder_name."\\".$controller_name."@destroy_multi');";
                $new_file[]="\n";
                $new_file[]="Route::post('".$route_name."/translate/{id}', '".$folder_name."\\".$controller_name."@translate_store');";
                $new_file[]="\n";
                $new_file[]="Route::get('".$route_name."/translate/{id}', '".$folder_name."\\".$controller_name."@translate')->name('".$route_name.".translate');";
                $new_file[]="\n";
                $new_file[]="Route::resource('".$route_name."', '".$folder_name."\\".$controller_name."', ['names' => '".$route_name."']);";
                $new_file[]="\n";

            }

        }
        file_put_contents($path, $new_file);
        return true;
    }
    // End Global Functions

    // Start Interface Building
    private function create_interface($folder_name,$interface_name){
        $path = base_path() . '/app/Repositories/Interfaces/custom_modules_management/'.$folder_name.'/'.$interface_name.'.php';
        if (! File::exists($path)) {
            $content=$this->interface_content($folder_name,$interface_name);
            File::put($path, $content);
        }

        return true;
    }
    private function interface_content($folder_name,$interface_name){

        $code='<?php ';
        $code .="\n";
        $code .='namespace App\Repositories\Interfaces\custom_modules_management\\'.$folder_name.';';
        $code .="\n";
        $code .="\n";
        $code .='interface '.$interface_name.'{';
        $code .="\n";
        $code .='public function data($request,$id="*");';
        $code .="\n";
        $code .='public function save($request,$id="");';
        $code .="\n";
        $code .='public function delete($id);';
        $code .="\n";
        $code .='public function translate($id);';
        $code .="\n";
        $code .='public function translate_store($request,$id);';
        $code .="\n";
        $code .='public function delete_multi($ids);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        return $code;
    }
    // End Interface Building

    // Start repository Building
    private function create_repository($folder_name,$repo_name,$interface_name,$model_name,$module_id){
        $path = base_path() . '/app/Repositories/Eloquent/custom_modules_management/'.$folder_name.'/'.$repo_name.'.php';
        if (! File::exists($path)) {
            $content=$this->repository_content($folder_name,$repo_name,$interface_name,$model_name,$module_id);
            File::put($path, $content);
        }

        return true;
    }
    public function repository_content($folder_name,$repo_name,$interface_name,$model_name,$module_id){

        $data=app(ModuleInterface::class)->data([],$module_id,'',true);
        $fields=$data['fields'];
        $images=[];
        $files=[];
        foreach($fields as $field){
            if($field->type=='image'){
                $images[]=$field->name;
            }
            if($field->type=='file'){
                $files[]=$field->name;
            }
        }
        if(count($images)>0){
            $string='';
            foreach($images as $image){
                $string.="'".$image."',";
            }
            $images='['.$string.']';
        }else{
            $images='[]';

        }
        if(count($files)>0){
            $string='';
            foreach($files as $file){
                $string.="'".$file."',";
            }
            $files='['.$string.']';
        }else{
            $files='[]';
        }
        $code='<?php';
        $code .="\n";
        $code .='namespace App\Repositories\Eloquent\custom_modules_management\\'.$folder_name.';';
        $code .="\n";
        $code .='use App\Repositories\Interfaces\custom_modules_management\\'.$folder_name.'\\'.$interface_name.';';
        $code .="\n";
        $code .='use App\Repositories\Interfaces\setting_management\LanguageInterface;';
        $code .="\n";
        $code .='use App\Repositories\Interfaces\builder_management\ModuleInterface;';
        $code .="\n";
        $code .='use App\Models\CustomModels\\'.$model_name.';';
        $code .="\n";
        $code .='use Exception;';
        $code .="\n";
        $code .='use File;';
        $code .="\n";
        $code .='use DB;';
        $code .="\n";
        $code .='use App\Events\CreateSlugEvent;';
        $code .="\n";
        $code .='use App\Events\CreateTranslationEvent;';
        $code .="\n";
        $code .='use App\Events\SetRelationEvent;';
        $code .="\n";
        $code .='use App\Events\SetCodeEvent;';
        $code .="\n";

        $code .="\n";
        $code .='class '.$repo_name.' implements '.$interface_name.' {';
        $code .="\n";
        $code .='public $model;';
        $code .="\n";
        $code .='private $files='.$files.';';
        $code .="\n";
        $code .='private $images='.$images.';';
        $code .="\n";
        $code .='private $json=[];';
        $code .="\n";
        $code .='public function __construct('.$model_name.' $model)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$this->model = $model;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .='public function data($request,$id="*",$field_name=""){';
        $code .="\n";
        $code .='$data = $this->model;';
        $code .="\n";
        $code .='$another_select=[];';
        $code .="\n";
        $code .='if ($id == "*") {';
        $code .="\n";
        $code .='if(array_key_exists("with",$request)){';
        $code .="\n";
        $code .='foreach ($request["with"] as $val){';
        $code .="\n";
        $code .='$another_select[]=$val;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$request["with"][]="slugable";';
        $code .="\n";
        $code .='$request["with"][]="codes";';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$request["with"] = ["slugable", "codes"];';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$data = StatementDB($data, $request);';
        $code .="\n";
        $code .='$data = $data->get();';
        $code .="\n";
        $code .='if (array_key_exists("select", $request) && !empty($request["select"])) {';
        $code .="\n";
        $code .='$request["select"]=array_merge($request["select"],$another_select);';
        $code .="\n";
        $code .='$data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='$data = $this->model->transformCollection($data);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='if(array_key_exists("with",$request)){';
        $code .="\n";
        $code .='foreach ($request["with"] as $val){';
        $code .="\n";
        $code .='$another_select[]=$val;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$request["with"][]="slugable";';
        $code .="\n";
        $code .='$request["with"][]="codes";';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$request["with"] = ["slugable", "codes"];';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$data = StatementDB($data, $request);';
        $code .="\n";
        $code .='$data = $data->where("id", $id);';
        $code .="\n";
        $code .='$data = $data->first();';
        $code .="\n";
        $code .='$data = $this->model->transformArray($data);';
        $code .="\n";
        $code .='if ($field_name != "") {';
        $code .="\n";
        $code .='$data = $data[$field_name];';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='return $data;';
        $code .="\n";
        $code .='}';
        $code .="\n";


        $code .='public function save($request,$id=""){';
        $code .="\n";
        $code .='try{';
        $code .="\n";
        $code .='if($id!=""){';
        $code .="\n";
        $code .='if($id!=$request["id"]){';
        $code .="\n";
        $code .='return false;';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='unset($request["id"]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='unset($request["_method"]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='unset($request["_token"]);';
        $code .="\n";
        $code .='foreach($this->json as $json){';
        $code .="\n";
        $code .='if(array_key_exists($json,$request)){';
        $code .="\n";
        $code .='$array=json_encode($request[$json]);';
        $code .="\n";
        $code .='$first_row=current($request[$json]);';
        $code .="\n";
        $code .='if(is_array($first_row)){';
        $code .="\n";
        $code .='$key=array_key_first($request[$json]);';
        $code .="\n";
        $code .='if($request[$json][$key][0]!=null){';
        $code .="\n";
        $code .='$array=json_encode($request[$json]);';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$array=json_encode([]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$request[$json]=$array;';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$array=json_encode([]);';
        $code .="\n";
        $code .='$request[$json]=$array;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .='foreach ($this->images as $image_name) {';
        $code .="\n";
        $code .='if (array_key_exists($image_name, $request)) {';
        $code .="\n";
        $code .='$image = request()->file($image_name);';
        $code .="\n";
        $code .='$image = uploadImage($image);';
        $code .="\n";
        $code .='$request[$image_name] = $image;';
        $code .="\n";
        $code .='if ($id != "") {';
        $code .="\n";
        $code .='$old_image = $this->data([], $id, $image_name);';
        $code .="\n";
        $code .='if(array_key_exists($image_name."_removed",$request)){';
        $code .="\n";
        $code .='$old_image=json_decode($old_image,true);';
        $code .="\n";
        $code .='$removed_images=$request[$image_name."_removed"];';
        $code .="\n";
        $code .='if($removed_images){';
        $code .="\n";
        $code .='$removed_images=explode(",",$removed_images);';
        $code .="\n";
        $code .='foreach($removed_images as $val){';
        $code .="\n";
        $code .='if(in_array($val,$old_image)){';
        $code .="\n";
        $code .='deleteFileStorage($val);';
        $code .="\n";
        $code .='$key = array_search($val, $old_image);';
        $code .="\n";
        $code .='unset($old_image[$key]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$new_image=json_decode($request[$image_name],true);';
        $code .="\n";
        $code .='$all_images=array_merge($old_image,$new_image);';
        $code .="\n";
        $code .='$request[$image_name]=json_encode($all_images);';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='deleteFileStorage($old_image);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='if ($id != "") {';
        $code .="\n";
        $code .='$old_image = $this->data([], $id, $image_name);';
        $code .="\n";
        $code .='if(array_key_exists($image_name."_removed",$request)){';
        $code .="\n";
        $code .='$removed_images=$request[$image_name."_removed"];';
        $code .="\n";
        $code .='$old_image=json_decode($old_image,true);';
        $code .="\n";
        $code .='if($removed_images){';
        $code .="\n";
        $code .='$removed_images=explode(",",$removed_images);';
        $code .="\n";
        $code .='foreach($removed_images as $val){';
        $code .="\n";
        $code .='if(in_array($val,$old_image)){';
        $code .="\n";
        $code .='deleteFileStorage($val);';
        $code .="\n";
        $code .='$key = array_search($val, $old_image);';
        $code .="\n";
        $code .='unset($old_image[$key]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$old_image=json_encode($old_image);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$request[$image_name] = $old_image;';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='$request[$image_name] = "";';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .='foreach ($this->files as $file_name) {';
        $code .="\n";
        $code .='if (array_key_exists($file_name, $request) && File::isFile($request[$file_name])) {';
        $code .="\n";
        $code .='$file = request()->file($file_name);';
        $code .="\n";
        $code .='$file = uploadFile($file);';
        $code .="\n";
        $code .='$request[$file_name] = $file;';
        $code .="\n";
        $code .='if ($id != "") {';
        $code .="\n";
        $code .='$old_file = $this->data([], $id, $file_name);';
        $code .="\n";
        $code .='if(array_key_exists($file_name."_removed",$request)){';
        $code .="\n";
        $code .='$old_file=json_decode($old_file,true);';
        $code .="\n";
        $code .='$removed_images=$request[$file_name."_removed"];';
        $code .="\n";
        $code .='if($removed_images){';
        $code .="\n";
        $code .='$removed_images=explode(",",$removed_images);';
        $code .="\n";
        $code .='foreach($removed_images as $val){';
        $code .="\n";
        $code .='if(in_array($val,$old_file)){';
        $code .="\n";
        $code .='deleteFileStorage($val);';
        $code .="\n";
        $code .='$key = array_search($val, $old_file);';
        $code .="\n";
        $code .='unset($old_file[$key]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$new_file=json_decode($request[$file_name],true);';
        $code .="\n";
        $code .='$all_files=array_merge($old_file,$new_file);';
        $code .="\n";
        $code .='$request[$file_name]=json_encode($all_files);';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='deleteFileStorage($old_file);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='if ($id != "") {';
        $code .="\n";
        $code .='$old_file = $this->data([], $id, $file_name);';
        $code .="\n";
        $code .='if(array_key_exists($file_name."_removed",$request)){';
        $code .="\n";
        $code .='$removed_images=$request[$file_name."_removed"];';
        $code .="\n";
        $code .='$old_file=json_decode($old_file,true);';
        $code .="\n";
        $code .='if($removed_images){';
        $code .="\n";
        $code .='$removed_images=explode(",",$removed_images);';
        $code .="\n";
        $code .='foreach($removed_images as $val){';
        $code .="\n";
        $code .='if(in_array($val,$old_file)){';
        $code .="\n";
        $code .='deleteFileStorage($val);';
        $code .="\n";
        $code .='$key = array_search($val, $old_file);';
        $code .="\n";
        $code .='unset($old_file[$key]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$old_file=json_encode($old_file);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$request[$file_name] = $old_file;';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='$request[$file_name] = "";';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";




        $code .='$data=$this->model->updateOrCreate(';
        $code .="\n";
        $code .='["id"=>$id],';
        $code .="\n";
        $code .='$request';
        $code .="\n";
        $code .=');';
        $code .="\n";
        $code .='if($id==""){';
        $code .="\n";
        $code .='$request["id"]=$data->id;';
        $code .="\n";
        $code .='event (new CreateTranslationEvent($request,$this->model->getTable()));';
        $code .="\n";
        $code .='unset($request["id"]);';
        $code .="\n";
        $code .='event (new SetRelationEvent($request,$this->model->getTable(),$data->id));';
        $code .="\n";
        $code .=' }';
        $code .="\n";
        $code .='event (new CreateSlugEvent($data,$this->model->getTable()));';
        $code .="\n";
        $code .='if(array_key_exists("codes",$request)){';
        $code .="\n";
        $code .='event (new SetCodeEvent($request["codes"],$this->model->getTable(),$data->id));';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='return $data;';
        $code .="\n";
        $code .='}catch(Exception $e){';
        $code .="\n";
        $code .='dd($e);';
        $code .="\n";
        $code .='return false;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .='public function delete($id){';
        $code .="\n";
        $code .='try{';
        $code .="\n";
        $code .='$data=$this->model->find($id);';
        $code .="\n";
        $code .='if(!$data){';
        $code .="\n";
        $code .='return false;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='foreach($this->images as $image_name){';
        $code .="\n";
        $code .='$old_image=$this->data([],$id,$image_name);';
        $code .="\n";
        $code .='deleteFileStorage($old_image);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='foreach($this->files as $file_name){';
        $code .="\n";
        $code .='$old_file=$this->data([],$id,$file_name);';
        $code .="\n";
        $code .='deleteFileStorage($old_file);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$data->delete();';
        $code .="\n";
        $code .='return true;';
        $code .="\n";
        $code .='}catch(Exception $e){';
        $code .="\n";
        $code .='return false;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";



        $code .="\n";
        $code .='public function translate($id){';
        $code .="\n";
        $code .='$data=$this->data(request()->all(),$id);';
        $code .="\n";
        $code .='$config=[];';
        $code .="\n";
        $code .='$request=[];';
        $code .="\n";
        $code .='$request["where"][]=["is_main"=>0];';
        $code .="\n";
        $code .='$request["select"]=["id","name","slug"];';
        $code .="\n";
        $code .='$config["langs"]=app(LanguageInterface::class)->data($request);';
        $code .="\n";
        $code .='$request=[];';
        $code .="\n";
        $code .='$request["where"][]=["is_main"=>0];';
        $code .="\n";
        $code .=' $fields=app(ModuleInterface::class)->data([],'.$module_id.');';
        $code .="\n";
        $code .='$fields=$fields["fields"];';
        $code .="\n";
        $code .='$fields_translate=[];';
        $code .="\n";
        $code .='$form="";';
        $code .="\n";
        $code .='foreach($fields as $field){';
        $code .="\n";
        $code .='if(in_array(6,json_decode($field->fields_action,true))){';
        $code .="\n";
        $code .='$fields_translate[]=$field;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$config["fields"]=$fields_translate;';
        $code .="\n";
        $code .='$config["data"]=$data["translate"];';
        $code .="\n";
        $code .='return $config;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='public function translate_store($request,$id){';
        $code .="\n";
        $code .='try{';
        $code .="\n";
        $code .='unset($request["_token"]);';
        $code .="\n";
        $code .='$table_name=$this->model->getTable();';
        $code .="\n";
        $code .='$field_name=explode("_",$table_name);';
        $code .="\n";
        $code .='unset($field_name[0]);';
        $code .="\n";
        $code .='$field_name=implode("_",$field_name)."_id";';
        $code .="\n";
        $code .='$table_name=$table_name."_translate";';
        $code .="\n";
        $code .='$insert=[];';
        $code .="\n";
        $code .='foreach($request as $lang=>$value){';
        $code .="\n";
        $code .='$value["lang"]=$lang;';
        $code .="\n";
        $code .='$value[$field_name]=$id;';
        $code .="\n";
        $code .='$insert[]=$value;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='DB::table($table_name)->where($field_name,$id)->delete();';
        $code .="\n";
        $code .='DB::table($table_name)->insert($insert);';
        $code .="\n";
        $code .='return true;';
        $code .="\n";
        $code .='}catch(Exception $e){';
        $code .="\n";
        $code .='return false;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='public function delete_multi($ids){';
        $code .="\n";
        $code .='try{';
        $code .="\n";
        $code .='$table_name=$this->model->table_name;';
        $code .="\n";
        $code .='foreach($ids as $id){';
        $code .="\n";
        $code .='foreach($this->images as $image_name){';
        $code .="\n";
        $code .='$old_image=$this->data([],$id,$image_name);';
        $code .="\n";
        $code .='deleteFileStorage($old_image);';
        $code .="\n";
        $code .=' }';
        $code .="\n";
        $code .=' foreach($this->files as $file_name){';
        $code .="\n";
        $code .='$old_file=$this->data([],$id,$file_name);';
        $code .="\n";
        $code .='deleteFileStorage($old_file);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .=' }';
        $code .="\n";
        $code .='$this->model->whereIn("id",$ids)->delete();';
        $code .="\n";
        $code .='return true;';
        $code .="\n";
        $code .='}catch(Exception $e){';
        $code .="\n";
        $code .='return false;';
        $code .="\n";
        $code .=' }';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .="\n";
        $code .='}';
        return $code;
    }
    // End repository Building

    // Start Model Building
    private function create_model($model_name,$DB_table,$module_id){

        $path = base_path() . '/app/Models/CustomModels/'.$model_name.'.php';
        if (! File::exists($path)) {
            Artisan::call('make:model Models/CustomModels/'.$model_name);
            $content=$this->model_content($model_name,$DB_table,$module_id);
            File::put($path, $content);
        }


        return true;
    }
    private function model_content($model_name,$DB_table,$module_id){
        $fields=getDBFieldsTable($module_id);
        $code='<?php';
        $code .="\n";
        $code .='namespace App\Models\CustomModels;';
        $code .="\n";
        $code .='use App\Models\Main;';
        $code .="\n";
        $code .='use App\Models\Slugable;';
        $code .="\n";
        $code .='use DB;';
        $code .="\n";
        $code .='use Illuminate\Database\Eloquent\SoftDeletes;';

        $code .="\n";
        $code .="\n";
        $code .='class '.$model_name.' extends Main';
        $code .="\n";
        $code .=' {';
        $code .="\n";
        $code .="use SoftDeletes;";
        $code .="\n";
        $code .=' protected $table = "'.$DB_table.'";';
        $code .="\n";
        $code .=' protected $fillable = [';
        foreach ($fields as $field_key=>$field){
            if($field_key=='deleted_at'){
                continue;
            }
            $code .='"'.$field_key.'",';
            $code .="\n";
        }
        $code .='"created_at",';
        $code .='"updated_at",';
        $code .='];';
        $code .="\n";
        $code .=' protected $hidden = [];';
        $code .="\n";
        $code .=' protected $casts = [];';
        $code .="\n";
        $code .=' public $timestamps = true;';
        $code .="\n";
        $code .='protected $attributes = [];';
        $code .="\n";

        $code .='public static function transform($item){';
        $code .="\n";
        $code .='$field_translate=static::translate($item->id);';
        $code .="\n";
        $code .='$transaction = new \stdclass();';
        $code .="\n";
        $code .='$transaction->id = $item->id;';
        $code .="\n";
        foreach ($fields as $field_key=>$field){
            if($field_key=='is_active'){
                $code .='$transaction->'.$field_key.'=($item->is_active==1)?"Active":"Blocked";';
            }else{
                $code .='$transaction->'.$field_key.'=$item->'.$field_key.';';
            }
            $code .="\n";
        }
        $code .='$transaction->translate=$field_translate;';
        $code .="\n";
        $code .=' $transaction->created_at = date("Y-m-d H:i:s",strtotime($item->created_at));';
        $code .="\n";
        $code .='$transaction->slug = ($item->slugable)?$item->slugable->slug:"";';
        $code .="\n";
        $code .='return $transaction;';
        $code .="\n";
        $code .=' }';
        $code .="\n";
        $code .="\n";

        $code .='public static function transformArray($item)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$field_translate=static::translate($item->id);';
        $code .="\n";
        $code .='$transaction = [];';
        $code .="\n";
        $code .='$transaction["id"] = $item->id;';
        $code .="\n";
        foreach ($fields as $field_key=>$field){
            $code .='$transaction["'.$field_key.'"] = $item->'.$field_key.';';
            $code .="\n";
        }
        $code .='$transaction["translate"]=$field_translate;';
        $code .="\n";
        $code .='$transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));';
        $code .="\n";
        $code .='$transaction["slug"] = ($item->slugable)?$item->slugable->slug:"";';
        $code .="\n";
        $code .='return $transaction;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .="\n";


        $code .='public static function transformCustom($item,$select){';
        $code .="\n";
        $code .='if($select=="*"){';
        $code .="\n";
        $code .='return self::transform($item);';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$transaction = new \stdclass();';
        $code .="\n";
        $code .='foreach ($select as $row) {';
        $code .="\n";
        $code .='$transaction->$row = $item->$row;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .='return $transaction;';
        $code .='}';
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='public static function translate($id){';
        $code .="\n";
        $code .='$model = new '.$model_name.';';
        $code .="\n";
        $code .='$table = explode("_",$model->getTable());';
        $code .="\n";
        $code .='unset($table[0]);';
        $code .="\n";
        $code .='$field_name=implode("_",$table)."_id";';
        $code .="\n";
        $code .='$table_name=$model->getTable()."_translate";';
        $code .="\n";
        $code .='$langs=DB::table($table_name)->where($field_name,$id)->get();';
        $code .="\n";
        $code .='$return=[];';
        $code .="\n";
        $code .='foreach($langs as $lang){';
        $code .="\n";
        $code .='$return[$lang->lang]=(array)$lang;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='return $return;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='public function slugable(){';
        $code .="\n";
        $code .='$table_name=SELF::getTable();';
        $code .="\n";
        $code .='return $this->hasOne(Slugable::class,"row_id","id")->where("table_name",$table_name);';
        $code .="\n";
        $code .='}';
        $code .="\n";




        $code .="\n";
        $code .='}';
        $code .="\n";
        return $code;
    }
    // End Model Building

    // Start Controller Building
    private function create_controller($folder_name,$controller_name,$interface_name,$route_name,$view_name,$model_name){
        // --resource
        Artisan::call('make:controller backend/custom_modules_management/'.$folder_name.'/'.$controller_name.'');
        $path = base_path() . '/app/Http/Controllers/backend/custom_modules_management/'.$folder_name.'/'.$controller_name.'.php';
        $content=$this->controller_content($folder_name,$controller_name,$interface_name,$route_name,$view_name,$model_name);
        File::put($path, $content);
        return true;
    }
    private function controller_content($folder_name,$controller_name,$interface_name,$route_name,$view_name,$model_name){

            $code='';
            $code .='<?php';
            $code .="\n";
            $code .='namespace App\Http\Controllers\backend\custom_modules_management\\'.$folder_name.';';
            $code .="\n";
            $code .='use App\Http\Controllers\Controller;';
            $code .="\n";
            $code .='use Illuminate\Http\Request;';
            $code .="\n";
            $code .='use App\Repositories\Interfaces\custom_modules_management\\'.$folder_name.'\\'.$interface_name.';';
            $code .="\n";
            $code .='use App\Http\Requests\backend\custom_modules_management\\'.$folder_name.'\\Store'.$model_name.'Request;';
            $code .="\n";
            $code .='use App\Http\Requests\backend\custom_modules_management\\'.$folder_name.'\\Edit'.$model_name.'Request;';
            $code .="\n";
            $code .='use  App\Jobs\ExportExcel;';
            $code .="\n";
            $code .='class '.$controller_name.' extends Controller';
            $code .="\n";
            $code .='{';
            $code .="\n";
            $code .='private $repository;';
            $code .="\n";
            $code .='private $config;';
            $code .="\n";
            $code .='public function __construct('.$interface_name.' $repository)';
            $code .="\n";
            $code .='{';
            $code .="\n";
            $code .='$this->repository = $repository;';
            $code .="\n";
            $code .='$route=request()->route()->getName();';
            $code .="\n";
            $code .='$config=setPageHead($route,"'.$folder_name.'","'.$model_name.'","'.$route_name.'");';
            $code .="\n";
            $code .='$this->config=$config;';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .="\n";
            $code .='public function index()';
            $code .="\n";
            $code .=' {';
            $code .="\n";
            $code .='$table=getTable("custom_modules_management/'.$folder_name.'/'.$view_name.'");';
            $code .="\n";
            $code .='return viewBackend("global","index",["table"=>$table,"config"=>$this->config]);';
            $code .="\n";
            $code .=' }';
            $code .="\n";
            $code .="\n";

            $code .='public function create()';
            $code .="\n";
            $code .='{';
            $code .="\n";
            $code .='$form=getForm("custom_modules_management/'.$folder_name.'/'.$view_name.'");';;
            $code .="\n";
            $code .='return viewBackend("global","create",["form"=>$form,"config"=>$this->config]);';
            $code .="\n";
            $code .=' }';
            $code .="\n";
            $code .="\n";
            $code .='public function store(Store'.$model_name.'Request $request)';
            $code .="\n";
            $code .='{';
            $code .='$save_and_edit=false;';
            $code .="\n";
            $code .='if(array_key_exists("save_and_edit",$request->all())){';
            $code .="\n";
            $code .='$save_and_edit=true;';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='$return=$this->repository->save($request->all());';
            $code .="\n";
            $code .='if($return==false){';
            $code .="\n";
            $code .='return redirect()->back()->with("error", "Error In Code Please Return To IT Team");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='if($save_and_edit){';
            $code .="\n";
            $code .='$redirect=route("'.$route_name.'.show",$return->id);';
            $code .="\n";
            $code .='}else{';
            $code .="\n";
            $code .='$redirect=route("'.$route_name.'.index");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='return response()->json(["message"=>"Your Record Created Successfully","redirect"=>$redirect]);';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .="\n";

            $code .='public function show($id)';
            $code .="\n";
            $code .='{';
            $code .="\n";
            $code .='$data=$this->repository->data([],$id);';
            $code .="\n";
            $code .='$form=getForm("custom_modules_management/'.$folder_name.'/'.$view_name.'",$id,$data);';
            $code .="\n";
            $code .='return viewBackend("global","edit",["form"=>$form,"config"=>$this->config]);';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .="\n";
            $code .='public function update(Edit'.$model_name.'Request $request, $id)';
            $code .="\n";
            $code .='{';
            $code .='$save_and_edit=false;';
            $code .="\n";
            $code .='if(array_key_exists("save_and_edit",$request->all())){';
            $code .="\n";
            $code .='$save_and_edit=true;';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='$return=$this->repository->save($request->all(),$id);';
            $code .="\n";
            $code .='if($return==false){';
            $code .="\n";
            $code .='return redirect()->back()->with("error", "Error In Code Please Return To IT Team");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='if($save_and_edit){';
            $code .="\n";
            $code .='$redirect=route("'.$route_name.'.show",$return->id);';
            $code .="\n";
            $code .='}else{';
            $code .="\n";
            $code .='$redirect=route("'.$route_name.'.index");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='return response()->json(["message"=>"Your Record Created Successfully","redirect"=>$redirect]);';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .="\n";
            $code .='public function destroy($id)';
            $code .="\n";
            $code .='{';
            $code .="\n";
            $code .='$return=$this->repository->delete($id);';
            $code .="\n";
            $code .='if($return==false){';
            $code .="\n";
            $code .='return redirect()->back()->with("error", "Error In Code Please Return To IT Team");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .="\n";
            $code .='return redirect()->back()->with("success", "Your Record Deleted Successfully");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .="\n";

            $code .="\n";
            $code .='public function translate($id){';
            $code .="\n";
            $code .='$data = $this->repository->data([], $id);';
            $code .="\n";
            $code .='$route=request()->route()->getName();';
            $code .="\n";
            $code .='$config = setPageHead($route, "'.$folder_name.'","'.$model_name.'","'.$route_name.'","(".$data["name"].")");';
            $code .="\n";
            $code .='$config["action"] = url("dashboard/modules/'.$route_name.'/translate/" . $id);';
            $code .="\n";
            $code .='$data = $this->repository->translate($id);';
            $code .="\n";
            $code .='return viewBackend("global", "translate", ["config" => array_merge($config,$data)]);';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .="\n";
            $code .='public function translate_store(Request $request,$id){';
            $code .="\n";
            $code .='$return=$this->repository->translate_store($request->all(),$id);';
            $code .="\n";
            $code .='if($return==false){';
            $code .="\n";
            $code .='return redirect()->back()->with("error", "Error In Code Please Return To IT Team");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='return redirect()->back()->with("success", "Your Record Created Successfully");';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .="\n";
            $code .='public function destroy_multi(Request $request){';
            $code .="\n";
            $code .=' $return=$this->repository->delete_multi($request->ids);';
            $code .="\n";
            $code .='if($return==false){';
            $code .="\n";
            $code .='return redirect()->back()->with("error", "Error In Code Please Return To IT Team");';
            $code .="\n";
            $code .='}';
            $code .="\n";
            $code .='return redirect()->back()->with("success", "Your Records Deleted Successfully");';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .="\n";
            $code .='public function export_excel(){';
            $code .="\n";
            $code .='$filters=request()->all();';
            $code .="\n";
            $code .='$interfaces=app('.$model_name.'::class);';
            $code .="\n";
            $code .='ExportExcel::dispatch($interfaces,$filters)->delay(now());';
            $code .="\n";
            $code .='return redirect()->back()->with("success", "You will get the required excel file within an hour");';
            $code .="\n";
            $code .='}';
            $code .="\n";

            $code .=' }';
            $code .="\n";
        return $code;
    }
    // End Controller Building

    //Start Table Design Building
    private function create_table_design($folder_name,$view_name,$route_name,$interface_name,$module_id){

        $path = base_path() . '/app/Tables/custom_modules_management/'.$folder_name.'/'.$view_name.'.php';
        $content=$this->table_design_content($folder_name,$interface_name,$route_name,$module_id);
        File::put($path, $content);
        return true;
    }

    private function table_design_content($folder_name,$interface_name,$route_name,$module_id){
        $request=[];
        $request['with']=['fields','crud_with_relation'];
        $data=app(ModuleInterface::class)->data($request,$module_id,'',true);
        $fields=$data['fields'];

        $code='';
        $code .='<?php';
        $code .="\n";
        $code .='use App\Repositories\Interfaces\custom_modules_management\\'.$folder_name.'\\'.$interface_name.';';
        $code .="\n";
        $code .="\n";
        $code .='function table($data = [])';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$related_to=false;';
        $code .="\n";
        $code .='if(array_key_exists("related_to",$data)){';
        $code .="\n";
        $code .='$related_to=$data["related_to"];';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$rows = [];';
        $code .="\n";
        $code .='$rows = table_design($rows);';
        $code .="\n";
        $code .=' $rows = table_body($rows);';
        $code .="\n";
        $code .='$rows = table_head($rows);';
        $code .="\n";
        $code .='$rows = table_buttons($rows,$related_to);';
        $code .="\n";
        $code .='$rows = table_filter($rows);';
        $code .="\n";
        $code .='return $rows;';
        $code .="\n";
        $code .='}';
        $code .="\n";



        $code .="\n";
        $code .='function table_head($rows)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$rows["head"] = [];';
        $code .="\n";
        $code .='$rows["head"]["id"] = "ID";';
        $code .="\n";
        $fields_in_table=[];
        foreach ($fields as $field){
            if(in_array(4,json_decode($field->fields_action,true)) && $field->is_active=='Active'){
                $code .='$rows["head"]["'.$field->name.'"] = "'.$field->show_as.'";';
                $code .="\n";
                $fields_in_table[]=['name'=>$field->name,'type'=>$field->type];
            }
        }
        $code .='$rows["head"]["created_at"] = "Created At";';
        $code .="\n";
        $code .='if ($rows["action"]["edit"] == true || $rows["action"]["delete"] == true || $rows["action"]["view"] == true) {';
        $code .="\n";
        $code .='$rows["head"]["action_buttons"] = "Action";';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='return $rows;';
        $code .="\n";
        $code .='}';
        $code .="\n";



        $code .="\n";
        $code .='function table_body($rows,$related_to=false)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$filters=request()->all();';
        $code .="\n";
        $code .='$request = [];';
        $code .="\n";
        $code .='$request=SetStatementDB($request,$filters);';
        $code .="\n";
        $code .='$records_count=app('.$interface_name.'::class)->model->count();';
        $code .="\n";
        $code .='$page=1;';
        $code .="\n";
        $code .='$offset=0;';
        $code .="\n";
        $code .='$pagination=false;';
        $code .="\n";
        $code .='if(request()->page && request()->page >= 1){';
        $code .="\n";
        $code .='$page=request()->page;';
        $code .="\n";
        $code .='$offset=($page * $request["row_in_page"])-$request["row_in_page"];';
        $code .="\n";
        $code .='$pagination=ceil($records_count / $request["row_in_page"]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$request["page"] = $page;';
        $code .="\n";
        $code .='$request["offset"] = $offset;';
        $code .="\n";
        $code .='$request["orderBy"]=[];';
        $code .="\n";
        $code .='$request["orderBy"]["created_at"]="desc";';
        $code .="\n";
        $code .='$body = app('.$interface_name.'::class)->data($request);';
        $code .="\n";
        $code .='$body=(array) json_decode(json_encode($body), true);';
        $code .="\n";
        $code .='$rows["body"] = $body;';
        $code .="\n";
        $code .='$rows["page"] = $page;';
        $code .="\n";
        $code .='if($body > $request["row_in_page"]){';
        $code .="\n";
        $code .='$rows["pagination"] = $pagination;';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$rows["pagination"] = $pagination;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$rows["main_url"] = url("dashboard/modules/'.$route_name.'/");';
        $code .="\n";
        $code .='$rows["records_count"] = $records_count;';
        $code .="\n";
        $code .='return $rows;';
        $code .="\n";
        $code .='}';
        $code .="\n";



        $code .="\n";
        $code .='function table_buttons($rows,$related_to=false)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$module_id='.$module_id.';';
        $code .="\n";
        $code .='$rows["table"] = [];';
        $code .="\n";
        $code .='$rows["table"]["multi_select"] = true;';
        $code .="\n";
        $code .='$rows["table"]["add"] = (checkAdminPermission("insert",$module_id))?true:false;';
        $code .="\n";
        $code .='$rows["table"]["add_link"] = route("'.$route_name.'.create");';
        $code .="\n";
        $code .='if($related_to!=false){';
        $code .="\n";
        $code .='$rows["table"]["add_link"] = route("'.$route_name.'.create")."?related_to=".$related_to;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$rows["table"]["delete_link"] = url("dashboard/modules/'.$route_name.'/");';
        $code .="\n";
        $code .='$rows["table"]["edit_link"]=url("dashboard/modules/'.$route_name.'/");';
        $code .="\n";
        $code .='$rows["table"]["status_change"]=false;';
        $code .="\n";
        $code .='$rows["table"]["delete_all"] = (checkAdminPermission("delete",$module_id))?true:false;;';
        $code .="\n";
        $code .='$rows["table"]["filter"] = false;';
        $code .="\n";
        $code .='$rows["table"]["export_excel"] = false;';
        $code .="\n";
        $code .='return $rows;';
        $code .="\n";
        $code .='}';
        $code .="\n";


        $code .="\n";
        $code .='function table_design($rows)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$module_id='.$module_id.';';
        $code .="\n";
        $code .='$rows["action"] = [];';
        $code .="\n";
        $code .='$rows["action"]["edit"] = (checkAdminPermission("show",$module_id))?true:false;';
        $code .="\n";
        $code .='$rows["action"]["delete"] = (checkAdminPermission("delete",$module_id))?true:false;';
        $code .="\n";
        $code .='$rows["action"]["view"] = false;';
        $code .="\n";
        $code .='$rows["action"]["links"] = [];';
        if(count($data["crud_with_relation"]) > 0){
            $code .="\n";
            foreach($data["crud_with_relation"] as $relation){
                $code .='$rows["action"]["links|][]=["name"=>"'.$relation->name.'","href"=>url("dashboard/modules/'.$relation->route_repo.'/"),"param"=>["id"]];';
                $code .="\n";
            }
        }
        $code .="\n";
        $code .='$rows["action"]["edit_without"] = [];';
        $code .="\n";
        $code .='$rows["action"]["delete_without"] = [];';
        $code .="\n";
        $code .='$rows["action"]["view_without"] = [];';
        $code .="\n";
        $code .='$rows["action"]["links_without"] = [];';
        $code .="\n";
        $code .='$rows["action"]["name"] = "'.$data['name'].' Controller";';
        $code .="\n";
        $code .='return $rows;';
        $code .="\n";
        $code .='}';
        $code .="\n";



        $code .="\n";
        $code .='function table_filter($rows)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$filter=request()->all();';
        $code .="\n";
        $code .='$rows["filter"] = [';
        $code .="\n";
        $code .='"created_from" => [';
        $code .="\n";
        $code .='"input_type" => "input",';
        $code .="\n";
        $code .='"type" => "date",';
        $code .="\n";
        $code .='"title" => "Created From",';
        $code .="\n";
        $code .='"name" => "created_from",';
        $code .="\n";
        $code .='"placeholder" => "Created From",';
        $code .="\n";
        $code .='"class" => "",';
        $code .="\n";
        $code .='"around_div" => "form-group form-md-line-input col-md-6",';
        $code .="\n";
        $code .='"below_div" => "",';
        $code .="\n";
        $code .='"value" => (array_key_exists("created_from",$filter))?$filter["created_from"]:"",';
        $code .="\n";
        $code .='],';
        $code .="\n";
        $code .='"created_to" => [';
        $code .="\n";
        $code .='"input_type" => "input",';
        $code .="\n";
        $code .='"type" => "date",';
        $code .="\n";
        $code .='"title" => "Created To",';
        $code .="\n";
        $code .='"name" => "created_to",';
        $code .="\n";
        $code .='"placeholder" => "Created To",';
        $code .="\n";
        $code .='"class" => "",';
        $code .="\n";
        $code .='"around_div" => "form-group form-md-line-input col-md-6",';
        $code .="\n";
        $code .='"below_div" => "",';
        $code .="\n";
        $code .='"value" => (array_key_exists("created_to",$filter))?$filter["created_to"]:"",';
        $code .="\n";
        $code .='],';
        $code .="\n";
        $code .='"id" => [';
        $code .="\n";
        $code .='"input_type" => "input",';
        $code .="\n";
        $code .='"type" => "number",';
        $code .="\n";
        $code .='"title" => "ID",';
        $code .="\n";
        $code .='"name" => "id",';
        $code .="\n";
        $code .='"placeholder" => "ID",';
        $code .="\n";
        $code .='"class" => "",';
        $code .="\n";
        $code .='"around_div" => "form-group form-md-line-input col-md-6",';
        $code .="\n";
        $code .='"below_div" => "",';
        $code .="\n";
        $code .='"value" => (array_key_exists("id",$filter))?$filter["id"]:"",';
        $code .="\n";
        $code .='],';
        $code .="\n";
        $code .='];';
        $code .="\n";
        $code .="\n";

        $code .='return $rows;';
        $code .="\n";
        $code .='}';
        $code .="\n";


        return $code;

    }
    //End Table Design Building

    //Start Form Design Building
    private function create_form_design($folder_name,$route_name,$view_name,$interface_name,$module_id){
        $path = base_path() . '/app/Forms/custom_modules_management/'.$folder_name.'/'.$view_name.'.php';

        $content=$this->form_design_content($route_name,$view_name,$interface_name,$folder_name,$module_id);

        File::put($path, $content);
        return true;
    }
    private function form_design_content($route_name,$view_name,$interface_name,$folder_name,$module_id){
        $request=[];
        $request['with']=['fields','crud_with_relation'];
        $data=app(ModuleInterface::class)->data($request,$module_id,'',true);

        $fields=json_decode(json_encode($data['fields']),true);
        $departments_module=json_decode($data['departments_module'],true);


        $code='';
        $code .='<?php';
        $code .="\n";
        $code .='function form($data = []) ';
         $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$fields = [];';
        $code .="\n";
        $count=0;
        $left_department=0;
        $right_department=0;

        foreach($departments_module['name'] as $department){
            if($departments_module['side'][$count]=='left'){
                $left_department++;
            }elseif($departments_module['side'][$count]=='right'){
                $right_department++;
            }

            $code .='$fields["'.$departments_module['side'][$count].'_'.$departments_module['order'][$count].'"]=[';
            $keys=array_keys(array_column($fields, 'with_group'),$departments_module['name'][$count]);

            foreach($keys as $key){

                $field=$fields[$key];
                $code .=getField($field);
            }

            $code .='];';
            $code .="\n";
            $count++;
        }
        $code .='$fields["form_edit"]=false;';
        $code .="\n";
        $code .='if(!empty($data)){';
        $code .="\n";
        $code .='$fields["form_edit"]=true;';
        $code .="\n";
        $code .='$fields["link_custom"]="";';
        $code .='}';
        $code .="\n";
        $code .='$fields = form_buttons($fields);';
        $code .="\n";
        $code .='if(empty($data)){';
        $code .="\n";
        $code .='$fields = form_attributes($fields);';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$fields = form_attributes($fields,$data["id"]);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$fields = form_design($fields);';
        $code .="\n";
        $code .='return $fields;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='function form_buttons($fields)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$module_id='.$module_id.';';
        $code .="\n";
        $code .='$fields["button_save"] = true;';
        $code .="\n";
        $code .='$fields["button_save_edit"] = true;';
        $code .="\n";
        $code .='$fields["send_mail"] = false;';
        $code .="\n";
        $code .='$fields["button_clear"] = false;';
        $code .="\n";
        $code .='if ($fields["form_edit"]) {';
        $code .="\n";
        $code .='$fields["custom_buttons"] = false;';
        $code .="\n";
        $code .='$fields["translate"] = (checkAdminPermission("translate",$module_id))?true:false;';
        $code .="\n";
        $code .='$fields["button_save"] = (checkAdminPermission("update",$module_id))?true:false;';
        $code .="\n";
        $code .='$fields["button_save_edit"] = (checkAdminPermission("update",$module_id))?true:false;';
        $code .="\n";
        $code .='} else {';
        $code .="\n";
        $code .='$fields["custom_buttons"] = false;';
        $code .="\n";
        $code .='$fields["translate"] = false;';
        $code .="\n";
        $code .='$fields["button_save"] = (checkAdminPermission("insert",$module_id))?true:false;';
        $code .="\n";
        $code .='$fields["button_save_edit"] = (checkAdminPermission("insert",$module_id))?true:false;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='return $fields;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='function form_attributes($fields,$id="")';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='if($id==""){';
        $code .="\n";
        $code .='$fields["action"] = route("'.$route_name.'.store");';
        $code .="\n";
        $code .='}else{';
        $code .="\n";
        $code .='$fields["action"] = route("'.$route_name.'.update",$id);';
        $code .="\n";
        $code .='}';
        $code .="\n";
        $code .='$fields["translate_href"] = url("dashboard/modules/'.$route_name.'/translate/".$id);';
        $code .="\n";
        $code .='$fields["method"] = "POST";';
        $code .="\n";
        $code .='$fields["class"] = "";';
        $code .="\n";
        $code .='$fields["id"] = $id;';
        $code .="\n";
        $code .='$fields["right_count"] = '.$right_department.';';
        $code .="\n";
        $code .='$fields["left_count"] = '.$left_department.';';
        $code .="\n";
        $code .='$fields["module_id"] = '.$module_id.';';
        $code .="\n";
        $string="false";
        if($left_department>0){
            $string="true";
        }
        $code .='$fields["left_corner"] ='.$string.';';
        $code .="\n";
        $code .='$fields["show_button"] = true;';
        $code .="\n";
        $code .='return $fields;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='function form_design($fields)';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $count=0;
        $left_department=0;
        $right_department=0;
        foreach($departments_module['name'] as $department){
            $code .='$fields["title_'.$departments_module['side'][$count].'_'.$departments_module['order'][$count].'"]="'.$departments_module['title'][$count].'";';
            $code .="\n";
            $code .='$fields["icon_'.$departments_module['side'][$count].'_'.$departments_module['order'][$count].'"]="'.$departments_module['icone'][$count].'";';
            $code .="\n";
            $count++;
        }
        $code .='return $fields;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='function form_options()';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='$DB_options = [];';
        $code .="\n";
        $code .='return $DB_options;';
        $code .="\n";
        $code .='}';
        $code .="\n";
        return $code;
    }
    //End Form Design Building

    //Start Request Building
    private function create_request($folder_name,$model_name,$module_id,$table_name){
        $path = base_path() . '/app/Http/Requests/backend/custom_modules_management/'.$folder_name.'/Store'.$model_name.'Request.php';
        $content=$this->create_request_content($folder_name,$model_name,$module_id,$table_name);
        File::put($path, $content);
        $path = base_path() . '/app/Http/Requests/backend/custom_modules_management/'.$folder_name.'/Edit'.$model_name.'Request.php';
        $content=$this->create_request_content($folder_name,$model_name,$module_id,$table_name,'Edit');
        File::put($path, $content);
        return true;
    }
    private function create_request_content($folder_name,$model_name,$module_id,$table_name,$type='Store'){
        $request=[];
        $request['with']=['fields','crud_with_relation'];
        $data=app(ModuleInterface::class)->data($request,$module_id,'',true);

        $fields=json_decode(json_encode($data['fields']),true);
        $validations=[];
        foreach($fields as $field){
            $validations[$field['name']]=[];
            if(in_array(3,json_decode($field['fields_action'],true))){
                $validations[$field['name']][]='required';
            }else{
                $validations[$field['name']][]='nullable';
            }
            if(in_array(2,json_decode($field['fields_action'],true))){
                if($type=='Store'){
                    $validations[$field['name']][]='unique:'.$table_name.','.$field['name'].'NULL,id,deleted_at,NULL';
                }else{
                    $validations[$field['name']][]='unique:'.$table_name.','.$field['name'].',".$id,id,deleted_at,NULL';
                }

            }
            if($field['min']){
                $validations[$field['name']][]='min:'.$field['min'];
            }
            if($field['max']){
                $validations[$field['name']][]='max:'.$field['max'];
            }

            if($field['type']=='email'){
                $validations[$field['name']][]='email:rfc,dns';
            }
            if($field['type']=='number'){
                $validations[$field['name']][]='integer';
            }
            if($field['type']=='image'){
                $images_type=app(GeneralInterface::class)->data()['image_type'];
                $images_type=implode(',',json_decode($images_type,true));
                $validations[$field['name']][]='image|mimes:'.$images_type;
            }
            if($field['type']=='multi_image'){
                $images_type=app(GeneralInterface::class)->data()['image_type'];
                $images_type=implode(',',json_decode($images_type,true));
                $validations[$field['name'].'.*'][]='image|mimes:'.$images_type.'';
            }
            if($field['type']=='file'){
                $files_type=app(GeneralInterface::class)->data()['file_type'];
                $files_type=implode(',',json_decode($files_type,true));
                $validations[$field['name']][]='file|mimes:'.$files_type;
            }
            if($field['type']=='multi_file'){
                $files_type=app(GeneralInterface::class)->data()['file_type'];
                $files_type=implode(',',json_decode($files_type,true));
                $validations[$field['name'].'.*'][]='file|mimes:'.$files_type.'';
            }
        }
        $code='';
        $code .='<?php';
        $code .="\n";
        $code .="\n";
        $code .='namespace App\Http\Requests\backend\custom_modules_management\\'.$folder_name.';';
        $code .="\n";
        $code .='use Illuminate\Foundation\Http\FormRequest;';
        $code .="\n";
        $code .='class '.$type.''.$model_name.'Request extends FormRequest';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='public function authorize()';
        $code .="\n";
        $code .='{';
        $code .="\n";
        $code .='return true;';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .=' public function rules()';
        $code .="\n";
        $code .='{';
        $code .="\n";
        if($type!='store'){
            $code .='$id=request()->id;';
            $code .="\n";
        }

        $code .='return [';
        $code .="\n";
        foreach ($validations as $key=>$value){
            $value=implode('|',$value);
            $code .='"'.$key.'" => "'.$value.'",';
            $code .="\n";
        }

        $code .='];';
        $code .="\n";
        $code .='}';
        $code .="\n";

        $code .="\n";
        $code .='}';
        return $code;

    }
    //End Request Building
}
