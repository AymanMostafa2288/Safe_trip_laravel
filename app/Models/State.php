<?php
namespace App\Models;

use App\Models\Main;
use DB;

class State extends Main
{
    protected $table = "install_states";
    protected $fillable = [

        "name_en",
        "name_ar",
        "code",
        "country_id",
        "created_at",
        "updated_at"
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];
    public static function transform($item)
    {

        // $field_translate = static::translate($item->id);
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name= currentLanguage('','name',$item,true);
        $transaction->code = $item->code;
        $transaction->country_id = $item->country_id;
        $transaction->country = ($item->country) ? Country::transform($item->country) : [];

        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $field_translate = static::translate($item->id);
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["name_en"] = $item->name_en;
        $transaction["name_ar"] = $item->name_ar;
        $transaction["code"] = $item->code;
        $transaction["country_id"] = $item->country_id;
        $transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction["country"] = ($item->country) ? Country::transform($item->country) : [];
        return $transaction;
    }

    public static function transformCustom($item, $select)
    {
        if ($select == "*") {
            return self::transform($item);
        } else {
            $transaction = new \stdclass();
            foreach ($select as $row) {
                if($row=='country'){
                    $transaction->$row =Country::transform($item->$row);
                }else{
                    $transaction->$row = $item->$row;
                }
            }
            return $transaction;
        }
    }



    public function country(){
        $table_name = SELF::getTable();
        return $this->belongsTo(Country::class, "country_id", "id");
    }

}
