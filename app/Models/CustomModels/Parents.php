<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parents extends Main
{
    use SoftDeletes;

    protected $table = "bus_families";
    protected $fillable = [
        "name",
        "code",
        "available_trips",
        "is_active",
        "created_at",
        "updated_at"
    ];
    protected $hidden     = [];
    protected $casts      = [];
    public $timestamps    = true;
    protected $attributes = [];

    public static function transform($item){
        $transaction                  = new \stdclass();
        $transaction->id              = $item->id;
        $transaction->name            = $item->name;
        $transaction->code            = $item->code;
        $transaction->available_trips = $item->available_trips;
        $transaction->is_active       = ActiveStatusEnum::options($item->is_active,true);
        $transaction->deleted_at      = $item->deleted_at;
        $transaction->created_at      = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item){

        $transaction                    = [];
        $transaction["id"]              = $item->id;
        $transaction["name"]            = $item->name;
        $transaction["code"]            = $item->code;
        $transaction["available_trips"] = $item->available_trips;
        $transaction["is_active"]       = $item->is_active;
        $transaction["members"]         = Member::transformCollection($item->members,'Array');
        $transaction["deleted_at"]      = $item->deleted_at;
        $transaction["created_at"]      = date("Y-m-d H:i:s", strtotime($item->created_at));
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
    public function members(){
      return $this->hasMany(Member::class,'family_id');
    }
}
