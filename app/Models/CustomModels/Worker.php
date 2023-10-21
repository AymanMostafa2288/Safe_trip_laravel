<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\WorkerTypeEnum;
use App\Models\Main;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Main
{
    use SoftDeletes;

    protected $table = "bus_workers";
    protected $fillable = [
        "name",
        "code",
        "mobile",
        "password",
        "national_id",
        "logo",
        "type",
        "gander",
        "is_active",
        "created_at",
        "updated_at"
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];

    public function setPasswordAttribute($password)
    {
        if($password){
            $this->attributes['password'] = bcrypt($password);
        }
    }

    public static function transform($item)
    {
        $transaction              = new \stdclass();
        $transaction->id          = $item->id;
        $transaction->name        = $item->name;
        $transaction->code        = $item->code;
        $transaction->mobile      = $item->mobile;
        $transaction->password    = $item->password;
        $transaction->national_id = $item->national_id;
        $transaction->logo        = $item->logo;
        $transaction->type        = $item->type;
        $transaction->gander      = $item->gander;
        $transaction->is_active   = ActiveStatusEnum::options($item->is_active,true);
        $transaction->deleted_at  = $item->deleted_at;
        $transaction->created_at  = date("Y-m-d H:i:s", strtotime($item->created_at));
        if($transaction->type == WorkerTypeEnum::DRIVER){
            $transaction->note             = $item->driver->note;
            $transaction->driving_license  = $item->driver->driving_license;
        }

        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction                = [];
        $transaction["id"]          = $item->id;
        $transaction["name"]        = $item->name;
        $transaction["code"]        = $item->code;
        $transaction["mobile"]      = $item->mobile;
        $transaction["password"]    = $item->password;
        $transaction["national_id"] = $item->national_id;
        $transaction["logo"]        = $item->logo;
        $transaction["type"]        = $item->type;
        $transaction["gander"]      = $item->gander;
        $transaction["is_active"]   = $item->is_active;
        $transaction["deleted_at"]  = $item->deleted_at;
        $transaction["created_at"]  = date("Y-m-d H:i:s", strtotime($item->created_at));
        if($item->type == WorkerTypeEnum::DRIVER){
            $transaction['note']             = $item->driver->note;
            $transaction['driving_license']  = $item->driver->driving_license;
        }
        if($item->type == WorkerTypeEnum::SUPERVISOR){

            $transaction['note'] = $item->supervisor->note;
        }
        return $transaction;
    }

    public static function transformCustom($item, $select)
    {
        if ($select == "*") {
            return self::transform($item);
        }else {
            $transaction = new \stdclass();
            foreach ($select as $row) {
                $transaction->$row = $item->$row;
            }
            return $transaction;
        }
    }
    public function driver(){
        return $this->hasOne(Driver::class,'worker_id');
    }
    public function supervisor(){
        return $this->hasOne(Supervisor::class,'worker_id');
    }



}
