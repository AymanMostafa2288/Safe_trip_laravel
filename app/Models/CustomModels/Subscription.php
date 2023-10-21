<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdclass;

class Subscription extends Main
{
    use SoftDeletes;

    protected $table = "bus_subscriptions";
    protected $fillable = [
        "family_id",
        "package_id",
        "count_of_price",
        "price",
        "is_active",
        "created_at"
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public static function transform($item)
    {
        $transaction = new stdclass();
        $transaction->id = $item->id;
        $transaction->family_id = $item->family_id;
        $transaction->family = $item->family;
        $transaction->package_id = $item->package_id;
        $transaction->package = $item->package;
        $transaction->count_of_price = $item->count_of_price;
        $transaction->price = $item->price;
        $transaction->is_active =  ActiveStatusEnum::options($item->is_active,true);
        $transaction->deleted_at = $item->deleted_at;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["family_id"] = $item->family_id;
        $transaction["package_id"]     = $item->package_id;
        $transaction["count_of_price"] = $item->count_of_price;
        $transaction["price"] = $item->price;
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
    public function family(){
        return $this->belongsTo(Parents::class,'family_id');
    }
    public function package(){
        return $this->belongsTo(Package::class,'package_id');
    }

}
