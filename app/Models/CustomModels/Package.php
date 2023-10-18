<?php
namespace App\Models\CustomModels;
use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Main
 {
use SoftDeletes;
 protected $table = "bus_packages";
 protected $fillable = ["route_id",
"name_ar",
"name_en",
"count_of_trip",
"price",
"note_ar",
"note_en",
"is_active",
"created_at","updated_at",];
 protected $hidden = [];
 protected $casts = [];
 public $timestamps = true;
protected $attributes = [];
public static function transform($item){
$field_translate=static::translate($item->id);
$transaction = new \stdclass();
$transaction->id = $item->id;
$transaction->route_id=$item->route_id;
$transaction->name_ar=$item->name_ar;
$transaction->name_en=$item->name_en;
$transaction->count_of_trip=$item->count_of_trip;
$transaction->price=$item->price;
$transaction->note_ar=$item->note_ar;
$transaction->note_en=$item->note_en;
$transaction->is_active=($item->is_active==1)?"Active":"Blocked";
$transaction->deleted_at=$item->deleted_at;
$transaction->translate=$field_translate;
 $transaction->created_at = date("Y-m-d H:i:s",strtotime($item->created_at));
$transaction->slug = ($item->slugable)?$item->slugable->slug:"";
return $transaction;
 }

public static function transformArray($item)
{
$field_translate=static::translate($item->id);
$transaction = [];
$transaction["id"] = $item->id;
$transaction["route_id"] = $item->route_id;
$transaction["name_ar"] = $item->name_ar;
$transaction["name_en"] = $item->name_en;
$transaction["count_of_trip"] = $item->count_of_trip;
$transaction["price"] = $item->price;
$transaction["note_ar"] = $item->note_ar;
$transaction["note_en"] = $item->note_en;
$transaction["is_active"] = $item->is_active;
$transaction["deleted_at"] = $item->deleted_at;
$transaction["translate"]=$field_translate;
$transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));
$transaction["slug"] = ($item->slugable)?$item->slugable->slug:"";
return $transaction;
}

public static function transformCustom($item,$select){
if($select=="*"){
return self::transform($item);
}else{
$transaction = new \stdclass();
foreach ($select as $row) {
$transaction->$row = $item->$row;
}
return $transaction;}}

public static function translate($id){
$model = new Package;
$table = explode("_",$model->getTable());
unset($table[0]);
$field_name=implode("_",$table)."_id";
$table_name=$model->getTable()."_translate";
$langs=DB::table($table_name)->where($field_name,$id)->get();
$return=[];
foreach($langs as $lang){
$return[$lang->lang]=(array)$lang;
}
return $return;
}

public function slugable(){
$table_name=SELF::getTable();
return $this->hasOne(Slugable::class,"row_id","id")->where("table_name",$table_name);
}

}
