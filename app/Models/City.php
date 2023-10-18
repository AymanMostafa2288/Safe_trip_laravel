<?php
namespace App\Models;

use App\Models\Main;
use App\Models\Slugable;
use DB;

class City extends Main
{
    protected $table = "install_cities";
    protected $fillable = [

        "name_en",
        "name_ar",
        "note",
        "state_id",
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

        $transaction->note = $item->note;
        $transaction->state_id = $item->state_id;
        $transaction->country_id = $item->country_id;
        $transaction->country = ($item->country) ? Country::transform($item->country) : [];

        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction->slug = ($item->slugable) ? $item->slugable->slug : "";
        return $transaction;
    }

    public static function transformArray($item)
    {
        $field_translate = static::translate($item->id);
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["name_en"] = $item->name_en;
        $transaction["name_ar"] = $item->name_ar;
        $transaction["note"] = $item->note;
        $transaction["country_id"] = $item->country_id;
        $transaction["translate"] = $field_translate;
        $transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));
        $transaction["country"] = ($item->country) ? Country::transform($item->country) : [];
        $transaction["state"] = ($item->state) ? Country::transform($item->state) : [];
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
        return $this->belongsTo(Country::class, "country_id", "id");
    }
    public function state(){
        return $this->belongsTo(State::class, "state_id", "id");
    }


}
