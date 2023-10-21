<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Route extends Main
{
    use SoftDeletes;

    protected $table = "bus_routes";
    protected $fillable = [
        "school_id",
        "name_ar",
        "name_en",
        "address_from",
        "address_to",
        "date_from",
        "date_to",
        "location_from",
        "location_to",
        "is_active",
        "created_at",
        "updated_at"
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public static function transform($item)
    {
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->school_id = $item->school_id;
        $transaction->school = $item->school;
        $transaction->name_ar = $item->name_ar;
        $transaction->name_en = $item->name_en;
        $transaction->address_from = $item->address_from;
        $transaction->address_to = $item->address_to;
        $transaction->location_from = $item->location_from;
        $transaction->location_to = $item->location_to;
        $transaction->date_from = date("Y-m-d", strtotime($item->date_from));
        $transaction->date_to = date("Y-m-d", strtotime($item->date_to));
        $transaction->is_active = ActiveStatusEnum::options($item->is_active,true);;
        $transaction->deleted_at = $item->deleted_at;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["school_id"] = $item->school_id;
        $transaction["name_ar"] = $item->name_ar;
        $transaction["name_en"] = $item->name_en;
        $transaction["address_from"] = $item->address_from;
        $transaction["address_to"] = $item->address_to;
        $transaction["location_from"] = $item->location_from;
        $transaction["location_to"] = $item->location_to;
        $transaction["date_from"] = date("Y-m-d", strtotime($item->date_from));
        $transaction["date_to"] = date("Y-m-d", strtotime($item->date_to));
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
            $transaction = new \stdclass();
            foreach ($select as $row) {
                $transaction->$row = $item->$row;
            }
            return $transaction;
        }
    }
    public function school(){
        return $this->belongsTo(School::class,'school_id');
    }
    public function trips(){
        return $this->hasMany(Trip::class,'route_id');
    }

}
