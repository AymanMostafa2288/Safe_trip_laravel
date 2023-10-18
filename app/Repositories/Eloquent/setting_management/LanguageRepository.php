<?php
namespace App\Repositories\Eloquent\setting_management;
use App\Models\Language;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
// use Stichoza\GoogleTranslate\GoogleTranslate;
use DB;
use File;
use Storage;
class LanguageRepository implements LanguageInterface {

    private $model;
    private $files = [];
    private $images = [];
    private $json = [];
    public function __construct(Language $model)
    {
        $this->model = $model;
    }
    public function data($request, $id = "*", $field_name = "")
    {
        if ($id == "*") {
            $data = $this->model;
            $data = StatementDB($data, $request);
            $data = $data->get();
            if (array_key_exists("select", $request) && !empty($request["select"])) {
                $data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);
            } else {
                $data = $this->model->transformCollection($data);
            }
        } else {
            $data = $this->model;
            $data = StatementDB($data, $request);
            $data = $data->where("id", $id);
            $data = $data->first();
            $data = $this->model->transformArray($data);

            if ($field_name != "") {
                $data = $data[$field_name];
            }
        }
        return $data;
    }
    public function save($request, $id = "")
    {
        try {
            if ($id != "") {
                if ($id != $request["id"]) {
                    return false;
                } else {
                    unset($request["id"]);
                }
                unset($request["_method"]);
            }
            unset($request["_token"]);
            foreach ($this->json as $json) {
                if (array_key_exists($json, $request)) {
                    $array = json_encode($request[$json]);
                    $first_row = current($request[$json]);
                    if (is_array($first_row)) {
                        $key = array_key_first($request[$json]);
                        if ($request[$json][$key][0] != null) {
                            $array = json_encode($request[$json]);
                        } else {
                            $array = json_encode([]);
                        }
                    }
                    $request[$json] = $array;
                } else {
                    $array = json_encode([]);
                    $request[$json] = $array;
                }
            }
            foreach ($this->images as $image_name) {
                if (array_key_exists($image_name, $request) && File::isFile($request[$image_name])) {
                    $image = request()->file($image_name);
                    $image = uploadImage($image);
                    $request[$image_name] = $image;
                    if ($id != "") {
                        $old_image = $this->data([], $id, $image_name);
                        deleteFileStorage($old_image);
                    }
                } else {
                    if ($id != "") {
                        $old_image = $this->data([], $id, $image_name);
                        $request[$image_name] = $old_image;
                    } else {
                        $request[$image_name] = "";
                    }
                }
            }
            $data = $this->model->updateOrCreate(
                ["id" => $id],
                $request
            );
            if($id==''){
                $this->set_language($data->slug);
            }
            return $data;
        } catch (Exception $e) {
            dd($e);
            return false;
        }
    }
    public function delete($id)
    {
        try {
            $data = $this->model->find($id);
            if (!$data) {
                return false;
            }
            $this->remove_language($data->slug);
            $data->delete();
        } catch (Exception $e) {
            return false;
        }
    }

    public function set_language($language){
        $folder_path=base_path() . '/resources/lang/'.$language;
        if (! File::exists($folder_path)) {
            File::makeDirectory($folder_path);
            $main_lang=getMainLanguage();
            // $main_lang='en';

            $words=include_once(base_path() . '/resources/lang/'.$main_lang.'/globals.php');
            $content=$this->get_content_file_lang($words,$language,true);
            $file=$folder_path.'/globals.php';
            File::put($file,$content);

            $words=include_once(base_path() . '/resources/lang/'.$main_lang.'/messages.php');
            $content=$this->get_content_file_lang($words,$language,true);
            $file=$folder_path.'/messages.php';
            File::put($file,$content);

            $words=include_once(base_path() . '/resources/lang/'.$main_lang.'/validations.php');
            $content=$this->get_content_file_lang($words,$language,true);
            $file=$folder_path.'/validations.php';
            File::put($file,$content);

            $words=include_once(base_path() . '/resources/lang/'.$main_lang.'/content.php');
            $content=$this->get_content_file_lang($words,$language,true);
            $file=$folder_path.'/content.php';
            File::put($file,$content);
        }
        return true;
    }
    private function remove_language($language){
        $folder_path=base_path() . '/resources/lang/'.$language;
        if (File::exists($folder_path)) {
            array_map('unlink', glob("$folder_path/*.*"));
            rmdir($folder_path);
        }
       return true;
    }
    public function get_content_file_lang($words,$language='en',$with_translate=false){
        $code='';
        $code.='<?php';
        $code .="\n";
        $code.='return[';
        $code .="\n";
        $connected=false;
        $main_lang=getMainLanguage();
        // $translate = new GoogleTranslate($main_lang);
        if($with_translate){
            $connected = @fsockopen("www.example.com", 80);
            $connected=false;
        }

        foreach($words as $key=>$value){
            if($connected){
                $value=$translate->setSource($main_lang)->setTarget($language)->translate($value);
            }
            $code.='"'.$key.'"=>"'.$value.'",';
            $code .="\n";
        }
        $code .="\n";
        $code.='];';
        return $code;
    }
    public function check_word_exists($language,$file,$word){
        $path_lang=base_path() . '/resources/lang/'.$language.'/'.$file.'.php';

        $words=include($path_lang);

       if(is_array($words)){

            if(!array_key_exists($word,$words)){
                $main_lang=getMainLanguage();
                $path_main_words=base_path() . '/resources/lang/'.$main_lang.'/'.$file.'.php';
                $main_words=include($path_main_words);
                if(!array_key_exists($word,$main_words)){
                    $this->set_words_in_language($word,$main_words,$path_main_words,$main_lang);
                }
                if($main_lang!=$language){
                    $this->set_words_in_language($word,$words,$path_lang,$language);
                }

            }
       }

    }
    private function set_words_in_language($word,$main_words,$path_lang,$language='en'){
        $main_lang=getMainLanguage();
        // $translate = new GoogleTranslate($main_lang);
        // $connected = @fsockopen("www.example.com", 80);
        $connected=false;
        // $main_words[$word]=($connected)?$translate->setSource($main_lang)->setTarget($language)->translate($word):$word;
        $main_words[$word]=$word;
        $content=$this->get_content_file_lang($main_words,$language);
        File::delete($path_lang);
        File::put($path_lang,$content);
    }

    public function translate_content($DB,$request){
        try{

            $DB_translate=$DB."_translate";
            $field_name=explode("_",$DB);
            unset($field_name[0]);
            $field_name=implode("_",$field_name)."_id";
            $filter=[];
            $filter["where"][]=['table_db'=>$DB];

            $fields=app(ModuleInterface::class)->data($filter);
            if(!$fields){
                return false;
            }
            $fields=$fields[0]->fields;

            $fields_translate=[];
            foreach($fields as $field){
                $fields_action=json_decode($field->fields_action,true);

                if(in_array(6,$fields_action)){
                    $fields_translate[]=$field;
                }

            }

            $main_lang=getMainLanguage();
            // $translate = new GoogleTranslate($main_lang);
            $connected = @fsockopen("www.example.com", 80);
            $connected = false;
            $filter=[];
            // $filter["where"][]=["is_main"=>0];
            $filter["select"]=["id","name","slug"];
            $languages=app(LanguageInterface::class)->data($filter);
            $insert=[];
            foreach($languages as $lang){
                $value=[];
                $value[$field_name]=$request['id'];
                $value['lang']=$lang->slug;
                foreach($fields_translate as $field){
                    if(array_key_exists($field->name,$request)){
                        $value=$request[$field->name];
                        // $value[$field->name]=($connected)?$translate->setSource($main_lang)->setTarget($lang->slug)->translate($request[$field->name]):$request[$field->name];
                    }else{
                        $value[$field->name]=null;
                    }

                }
                $value['created_at']=date('Y-m-d H:i:s');
                $insert[]=$value;
            }
            DB::table($DB_translate)->insert($insert);
        }catch(Exception $e){
            return false;
        }

    }
}
?>
