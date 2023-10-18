<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Main
{
    use SoftDeletes;

    protected $table = "bus_drivers";
    protected $fillable = [
        "worker_id",
        "driving_license",
        "note",
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
        $transaction                  = new \stdclass();
        $transaction->id              = $item->id;
        $transaction->worker_id       = $item->worker_id;
        $transaction->driving_license = $item->driving_license;
        $transaction->note            = $item->note;
        $transaction->is_active       = ActiveStatusEnum::options($item->is_active,true);
        $transaction->deleted_at      = $item->deleted_at;
        $transaction->created_at      = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction                    = [];
        $transaction["id"]              = $item->id;
        $transaction["worker_id"]       = $item->worker_id;
        $transaction["driving_license"] = $item->driving_license;
        $transaction["note"]            = $item->note;
        $transaction["is_active"]       = $item->is_active;
        $transaction["deleted_at"]      = $item->deleted_at;
        $transaction["created_at"]      = date("Y-m-d H:i:s", strtotime($item->created_at));
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



}
