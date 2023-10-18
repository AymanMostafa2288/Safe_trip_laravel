<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bus extends Main
{
    use SoftDeletes;

    protected $table = "bus_buses";
    protected $fillable = [
        "vehicle_license",
        "vehicle_number",
        "passenger_capacity",
        "passenger_available",
        "color_code",
        "status",
        "is_active",
        "created_at",
        "updated_at"
    ];
    protected $hidden     = [];
    protected $casts      = [];
    public $timestamps    = true;
    protected $attributes = [];

    public static function transform($item){
        $transaction                      = new \stdclass();
        $transaction->id                  = $item->id;
        $transaction->vehicle_license     = $item->vehicle_license;
        $transaction->vehicle_number      = $item->vehicle_number;
        $transaction->passenger_capacity  = $item->passenger_capacity;
        $transaction->passenger_available = $item->passenger_available;
        $transaction->color_code          = $item->color_code;
        $transaction->status              = $item->status;
        $transaction->is_active           = ActiveStatusEnum::options($item->is_active,true);
        $transaction->deleted_at          = $item->deleted_at;
        $transaction->created_at          = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item){

        $transaction = [];
        $transaction["id"]                  = $item->id;
        $transaction["vehicle_license"]     = $item->vehicle_license;
        $transaction["vehicle_number"]      = $item->vehicle_number;
        $transaction["passenger_capacity"]  = $item->passenger_capacity;
        $transaction["passenger_available"] = $item->passenger_available;
        $transaction["color_code"]          = $item->color_code;
        $transaction["status"]              = $item->status;
        $transaction["is_active"]           = $item->is_active;
        $transaction["deleted_at"]          = $item->deleted_at;
        $transaction["created_at"]          = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformCustom($item, $select){

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



}
