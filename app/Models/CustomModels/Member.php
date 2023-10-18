<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Main
{
    use SoftDeletes;

    protected $table = "bus_members";
    protected $fillable = [
        "name",
        "email",
        "phone",
        "family_id",
        "national_id",
        'gander',
        'password',
        'relation',
        'is_active',
        "created_at",
        "updated_at"
    ];
    protected $hidden     = [
        'password'
    ];
    protected $casts      = [];
    public $timestamps    = true;
    protected $attributes = [];

    public function setPasswordAttribute($password)
    {
        if($password){
            $this->attributes['password'] = bcrypt($password);
        }
    }
    public static function transform($item){
        $transaction                  = new \stdclass();
        $transaction->id              = $item->id;
        $transaction->name            = $item->name;
        $transaction->email           = $item->email;
        $transaction->phone           = $item->phone;
        $transaction->national_id     = $item->national_id;
        $transaction->gander          = $item->gander;
        $transaction->relation        = $item->relation;
        $transaction->is_active       = ActiveStatusEnum::options($item->is_active,true);
        $transaction->family_id       = $item->family_id;
        $transaction->family          = Parents::transform($item->family);
        $transaction->deleted_at      = $item->deleted_at;
        $transaction->created_at      = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item){
        $transaction                    = [];
        $transaction["id"]              = $item->id;
        $transaction["name"]            = $item->name;
        $transaction["email"]           = $item->email;
        $transaction["phone"]           = $item->phone;
        $transaction["national_id"]     = $item->national_id;
        $transaction["gander"]          = $item->gander;
        $transaction["relation"]        = $item->relation;
        $transaction["is_active"]       = $item->is_active;
        $transaction['family_id']       = $item->family_id;
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
    public function family(){
        return $this->belongsTo(Parents::class,'family_id');
    }
}
