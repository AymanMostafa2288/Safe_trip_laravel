<?php

namespace App\Models;

use App\Models\Main;
use DB;

class District extends Main
{
    protected $table = "install_districts";
    protected $fillable = [
        "name_en",
        "name_ar",
        "city_id",
        "state_id",
        "country_id",
        "created_at",
        "updated_at",
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
        $transaction->city_id = $item->city_id;
        $transaction->city = ($item->city) ? City::transform($item->city) : [];

        $transaction->state_id = $item->state_id;
        $transaction->state = ($item->state) ? State::transform($item->state) : [];

        $transaction->country_id = $item->country_id;
        $transaction->country = ($item->country) ? Country::transform($item->country) : [];

        // $transaction->translate = $field_translate;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["name_en"] = $item->name_en;
        $transaction["name_ar"] = $item->name_ar;

        $transaction["city_id"] = $item->city_id;
        $transaction["city"] = ($item->city) ? City::transform($item->city) : [];

        $transaction["state_id"] = $item->state_id;
        $transaction["state"] = ($item->state) ? State::transform($item->state) : [];

        $transaction["country_id"] = $item->country_id;
        $transaction["country"] = ($item->country) ? Country::transform($item->country) : [];


        $transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformCustom($item, $select)
    {
        if ($select == "*") {
            return self::transform($item);
        } else {
            $transaction = new \stdclass();
            foreach ($select as $row) {
                $transaction->$row = $item->$row;
            }
            return $transaction;
        }
    }



    public function country(){
        $table_name = SELF::getTable();
        return $this->belongsTo(Country::class, "country_id", "id");
    }

    public function state(){
        $table_name = SELF::getTable();
        return $this->belongsTo(State::class, "state_id", "id");
    }

    public function city(){
        $table_name = SELF::getTable();
        return $this->belongsTo(City::class, "city_id", "id");
    }
}
