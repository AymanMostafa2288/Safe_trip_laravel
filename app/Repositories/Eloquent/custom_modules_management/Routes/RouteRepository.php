<?php
namespace App\Repositories\Eloquent\custom_modules_management\Routes;
use App\Repositories\Interfaces\custom_modules_management\Routes\RouteInterface;
use App\Repositories\Interfaces\setting_management\LanguageInterface;
use App\Repositories\Interfaces\builder_management\ModuleInterface;
use App\Models\CustomModels\Route;
use Exception;
use File;
use DB;
use App\Events\CreateSlugEvent;
use App\Events\CreateTranslationEvent;
use App\Events\SetRelationEvent;
use App\Events\SetCodeEvent;

class RouteRepository implements RouteInterface {
public $model;
private $files=[];
private $images=[];
private $json=[];
public function __construct(Route $model)
{
$this->model = $model;
}
public function data($request,$id="*",$field_name=""){
$data = $this->model;
$another_select=[];
if ($id == "*") {
if(array_key_exists("with",$request)){
foreach ($request["with"] as $val){
$another_select[]=$val;
}
$request["with"][]="slugable";
$request["with"][]="codes";
}else{
$request["with"] = ["slugable", "codes"];
}
$data = StatementDB($data, $request);
$data = $data->get();
if (array_key_exists("select", $request) && !empty($request["select"])) {
$request["select"]=array_merge($request["select"],$another_select);
$data = $this->model->transformCollection($data, "Custom", false, false, $request["select"]);
} else {
$data = $this->model->transformCollection($data);
}
} else {
if(array_key_exists("with",$request)){
foreach ($request["with"] as $val){
$another_select[]=$val;
}
$request["with"][]="slugable";
$request["with"][]="codes";
}else{
$request["with"] = ["slugable", "codes"];
}
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
public function save($request,$id=""){
try{
if($id!=""){
if($id!=$request["id"]){
return false;
}else{
unset($request["id"]);
}
unset($request["_method"]);
}
unset($request["_token"]);
foreach($this->json as $json){
if(array_key_exists($json,$request)){
$array=json_encode($request[$json]);
$first_row=current($request[$json]);
if(is_array($first_row)){
$key=array_key_first($request[$json]);
if($request[$json][$key][0]!=null){
$array=json_encode($request[$json]);
}else{
$array=json_encode([]);
}
}
$request[$json]=$array;
}else{
$array=json_encode([]);
$request[$json]=$array;
}
}
foreach ($this->images as $image_name) {
if (array_key_exists($image_name, $request)) {
$image = request()->file($image_name);
$image = uploadImage($image);
$request[$image_name] = $image;
if ($id != "") {
$old_image = $this->data([], $id, $image_name);
if(array_key_exists($image_name."_removed",$request)){
$old_image=json_decode($old_image,true);
$removed_images=$request[$image_name."_removed"];
if($removed_images){
$removed_images=explode(",",$removed_images);
foreach($removed_images as $val){
if(in_array($val,$old_image)){
deleteFileStorage($val);
$key = array_search($val, $old_image);
unset($old_image[$key]);
}
}
}
$new_image=json_decode($request[$image_name],true);
$all_images=array_merge($old_image,$new_image);
$request[$image_name]=json_encode($all_images);
}else{
deleteFileStorage($old_image);
}
}
} else {
if ($id != "") {
$old_image = $this->data([], $id, $image_name);
if(array_key_exists($image_name."_removed",$request)){
$removed_images=$request[$image_name."_removed"];
$old_image=json_decode($old_image,true);
if($removed_images){
$removed_images=explode(",",$removed_images);
foreach($removed_images as $val){
if(in_array($val,$old_image)){
deleteFileStorage($val);
$key = array_search($val, $old_image);
unset($old_image[$key]);
}
}
}
$old_image=json_encode($old_image);
}
$request[$image_name] = $old_image;
} else {
$request[$image_name] = "";
}
}
}
foreach ($this->files as $file_name) {
if (array_key_exists($file_name, $request) && File::isFile($request[$file_name])) {
$file = request()->file($file_name);
$file = uploadFile($file);
$request[$file_name] = $file;
if ($id != "") {
$old_file = $this->data([], $id, $file_name);
if(array_key_exists($file_name."_removed",$request)){
$old_file=json_decode($old_file,true);
$removed_images=$request[$file_name."_removed"];
if($removed_images){
$removed_images=explode(",",$removed_images);
foreach($removed_images as $val){
if(in_array($val,$old_file)){
deleteFileStorage($val);
$key = array_search($val, $old_file);
unset($old_file[$key]);
}
}
}
$new_file=json_decode($request[$file_name],true);
$all_files=array_merge($old_file,$new_file);
$request[$file_name]=json_encode($all_files);
}else{
deleteFileStorage($old_file);
}
}
} else {
if ($id != "") {
$old_file = $this->data([], $id, $file_name);
if(array_key_exists($file_name."_removed",$request)){
$removed_images=$request[$file_name."_removed"];
$old_file=json_decode($old_file,true);
if($removed_images){
$removed_images=explode(",",$removed_images);
foreach($removed_images as $val){
if(in_array($val,$old_file)){
deleteFileStorage($val);
$key = array_search($val, $old_file);
unset($old_file[$key]);
}
}
}
$old_file=json_encode($old_file);
}
$request[$file_name] = $old_file;
} else {
$request[$file_name] = "";
}
}
}
$data=$this->model->updateOrCreate(
["id"=>$id],
$request
);
if($id==""){
$request["id"]=$data->id;
event (new CreateTranslationEvent($request,$this->model->getTable()));
unset($request["id"]);
event (new SetRelationEvent($request,$this->model->getTable(),$data->id));
 }
event (new CreateSlugEvent($data,$this->model->getTable()));
if(array_key_exists("codes",$request)){
event (new SetCodeEvent($request["codes"],$this->model->getTable(),$data->id));
}
return $data;
}catch(Exception $e){
dd($e);
return false;
}
}
public function delete($id){
try{
$data=$this->model->find($id);
if(!$data){
return false;
}
foreach($this->images as $image_name){
$old_image=$this->data([],$id,$image_name);
deleteFileStorage($old_image);
}
foreach($this->files as $file_name){
$old_file=$this->data([],$id,$file_name);
deleteFileStorage($old_file);
}
$data->delete();
return true;
}catch(Exception $e){
return false;
}
}

public function translate($id){
$data=$this->data(request()->all(),$id);
$config=[];
$request=[];
$request["where"][]=["is_main"=>0];
$request["select"]=["id","name","slug"];
$config["langs"]=app(LanguageInterface::class)->data($request);
$request=[];
$request["where"][]=["is_main"=>0];
 $fields=app(ModuleInterface::class)->data([],7);
$fields=$fields["fields"];
$fields_translate=[];
$form="";
foreach($fields as $field){
if(in_array(6,json_decode($field->fields_action,true))){
$fields_translate[]=$field;
}
}
$config["fields"]=$fields_translate;
$config["data"]=$data["translate"];
return $config;
}

public function translate_store($request,$id){
try{
unset($request["_token"]);
$table_name=$this->model->getTable();
$field_name=explode("_",$table_name);
unset($field_name[0]);
$field_name=implode("_",$field_name)."_id";
$table_name=$table_name."_translate";
$insert=[];
foreach($request as $lang=>$value){
$value["lang"]=$lang;
$value[$field_name]=$id;
$insert[]=$value;
}
DB::table($table_name)->where($field_name,$id)->delete();
DB::table($table_name)->insert($insert);
return true;
}catch(Exception $e){
return false;
}
}

public function delete_multi($ids){
try{
$table_name=$this->model->table_name;
foreach($ids as $id){
foreach($this->images as $image_name){
$old_image=$this->data([],$id,$image_name);
deleteFileStorage($old_image);
 }
 foreach($this->files as $file_name){
$old_file=$this->data([],$id,$file_name);
deleteFileStorage($old_file);
}
 }
$this->model->whereIn("id",$ids)->delete();
return true;
}catch(Exception $e){
return false;
 }
}

}