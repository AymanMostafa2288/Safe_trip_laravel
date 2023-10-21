<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdclass;

class Package extends Main
{
    use SoftDeletes;

    protected $table = "bus_packages";
    protected $fillable = [
        "route_id",
        "name_ar",
        "name_en",
        "count_of_trip",
        "price",
        "note_ar",
        "note_en",
        "is_active",
        "created_at",
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public static function transform($item)
    {
        $transaction = new stdclass();
        $transaction->id = $item->id;
        $transaction->route_id = $item->route_id;
        $transaction->name_ar = $item->name_ar;
        $transaction->name_en = $item->name_en;
        $transaction->count_of_trip = $item->count_of_trip;
        $transaction->price = $item->price;
        $transaction->note_ar = $item->note_ar;
        $transaction->note_en = $item->note_en;
        $transaction->is_active = ActiveStatusEnum::options($item->is_active,true);
        $transaction->deleted_at = $item->deleted_at;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
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
        $transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformCustom($item, $select)
    {
        if ($select == "*") {
            return self::transform($item);
        } else {
            $transaction = new stdclass();
            foreach ($select as $row) {
                $transaction->$row = $item->$row;
            }
            return $transaction;
        }
    }

}
