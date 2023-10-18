<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Main
{
    use SoftDeletes;

    protected $table = "bus_students";
    protected $fillable = [
        "family_id",
        "logo",
        "name",
        "phone",
        "code",
        "gander",
        "address",
        "note",
        "is_active",
        "created_at",
        "updated_at"
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public static function transform($item){

        $transaction             = new \stdclass();
        $transaction->id         = $item->id;
        $transaction->family_id  = $item->family_id;
        $transaction->logo       = $item->logo;
        $transaction->name       = $item->name;
        $transaction->phone      = $item->phone;
        $transaction->code       = $item->code;
        $transaction->gander     = $item->gander;
        $transaction->address    = $item->address;
        $transaction->note       = $item->note;
        $transaction->family     = $item->family;
        $transaction->is_active  = ActiveStatusEnum::options($item->is_active,true);
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item){

        $transaction               = [];
        $transaction["id"]         = $item->id;
        $transaction["family_id"]  = $item->family_id;
        $transaction["logo"]       = $item->logo;
        $transaction["name"]       = $item->name;
        $transaction["phone"]      = $item->phone;
        $transaction["code"]       = $item->code;
        $transaction["gander"]     = $item->gander;
        $transaction["address"]    = $item->address;
        $transaction["note"]       = $item->note;
        $transaction["is_active"]  = $item->is_active;
        $transaction["created_at"] = date("Y-m-d H:i:s", strtotime($item->created_at));
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
    public function family(){
        return $this->belongsTo(Parents::class,'family_id');
    }

}
