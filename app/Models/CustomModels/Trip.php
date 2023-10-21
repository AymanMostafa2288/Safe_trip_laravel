<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;

class Trip extends Main
{
    protected $table = "bus_trips";
    protected $fillable = [
        "route_id",
        "driver_id",
        "supervisor_id",
        "bus_id",
        "trip_id",
        "day",
        "time_start",
        "time_end",
        "actual_time_start",
        "actual_time_end",
        "status",
        "is_active",
        "created_at",
        "updated_at"
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public static function transform($item){
        $transaction                    = new \stdclass();
        $transaction->id                = $item->id;
        $transaction->route_id          = $item->route_id;
        $transaction->driver_id         = $item->driver_id;
        $transaction->supervisor_id     = $item->supervisor_id;
        $transaction->bus_id            = $item->bus_id;
        $transaction->trip_id           = $item->trip_id;
        $transaction->day               = date("Y-m-d", strtotime($item->day));
        $transaction->time_start        = date("H:i", strtotime($item->time_start));
        $transaction->time_end          = date("H:i", strtotime($item->time_end));
        $transaction->actual_time_start = date("Y-m-d H:i:s", strtotime($item->actual_time_start));
        $transaction->actual_time_end   = date("Y-m-d H:i:s", strtotime($item->actual_time_end));
        $transaction->status            = $item->status;
        $transaction->route             = $item->route;
        $transaction->is_active         = ActiveStatusEnum::options($item->is_active,true);
        $transaction->created_at        = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item){
        $transaction                      = [];
        $transaction["id"]                = $item->id;
        $transaction["route_id"]          = $item->route_id;
        $transaction["driver_id"]         = $item->driver_id;
        $transaction["supervisor_id"]     = $item->supervisor_id;
        $transaction["bus_id"]            = $item->bus_id;
        $transaction["trip_id"]           = $item->trip_id;
        $transaction["day"]               = date("Y-m-d", strtotime($item->day));
        $transaction["time_start"]        = date("H:i", strtotime($item->time_start));
        $transaction["time_end"]          = date("H:i", strtotime($item->time_end));
        $transaction["actual_time_start"] = date("Y-m-d H:i:s", strtotime($item->actual_time_start));
        $transaction["actual_time_end"]   = date("Y-m-d H:i:s", strtotime($item->actual_time_end));
        $transaction["status"]            = $item->status;
        $transaction["is_active"]         = $item->is_active;
        $transaction["created_at"]        = date("Y-m-d H:i:s", strtotime($item->created_at));
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
    public function route(){
        return $this->belongsTo(Route::class,'route_id');
    }
    public function driver(){
        return $this->belongsTo(Worker::class,'driver_id');
    }
    public function supervisor(){
        return $this->belongsTo(Worker::class,'supervisor_id');
    }
    public function bus(){
        return $this->belongsTo(Bus::class,'bus_id');
    }
    public function trip(){
        return $this->hasOne(Trip::class,'trip_id');
    }
}
