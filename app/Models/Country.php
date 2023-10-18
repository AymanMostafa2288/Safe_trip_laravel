<?php
namespace App\Models;

use App\Models\Main;
use App\Models\Slugable;
use DB;

class Country extends Main
{
    protected $table = "install_countries";
    protected $fillable = [
        "name_en",
        "name_ar",
        "code",
        'iso',
        'iso3',
        'numcode',
        "image",
        "created_at",
        "updated_at",
    ];
    protected $hidden = [
        'updated_at'
    ];
    protected $casts = [
        'id' => 'integer',
        'created_at' => 'datetime',
    ];
    public $timestamps = true;
    protected $attributes = [];
    public static function transform($item)
    {
        // $field_translate = static::translate($item->id);
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name= currentLanguage('','name',$item,true);
        $transaction->code = $item->code;
        $transaction->image = $item->image;
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
        $transaction["code"] = $item->code;
        $transaction["image"] = $item->image;
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
            return $transaction;}
    }



}
