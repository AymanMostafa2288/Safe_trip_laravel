<?php

namespace App\Models\CustomModels;

use App\Enum\ActiveStatusEnum;
use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Main
{
    use SoftDeletes;

    protected $table = "bus_schools";
    protected $fillable = [
        "name_ar",
        "name_en",
        "phone",
        "email",
        "address",
        "logo",
        "about",
        "location",
        "is_active",
        "created_at"
        ];
    protected $hidden     = [];
    protected $casts      = [];
    public $timestamps    = true;
    protected $attributes = ['name'];


    public function getNameAttribute() {

//        return $this->first_name . ' ' . $this->last_name;
    }
    public static function transform($item)
    {
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name_ar = $item->name_ar;
        $transaction->name_en = $item->name_en;
        $transaction->phone = $item->phone;
        $transaction->email = $item->email;
        $transaction->address = $item->address;
        $transaction->logo = $item->logo;
        $transaction->about = $item->about;
        $transaction->location = $item->location;
        $transaction->is_active = ActiveStatusEnum::options($item->is_active,true);
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["name_ar"] = $item->name_ar;
        $transaction["name_en"] = $item->name_en;
        $transaction["phone"] = $item->phone;
        $transaction["email"] = $item->email;
        $transaction["address"] = $item->address;
        $transaction["logo"] = $item->logo;
        $transaction["about"] = $item->about;
        $transaction["location"] = $item->location;
        $transaction["is_active"] = $item->is_active;
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

}
