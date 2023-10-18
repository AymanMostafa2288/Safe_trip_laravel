<?php

namespace App\Models;

use App\Models\Main;
use App\Models\Slugable;
use DB;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Main
{
    use SoftDeletes;
    protected $table = "install_notifications";
    protected $fillable = [
        "name",
        "icon",
        "table_db",
        "field_name",
        "field_value",
        "message",
        "is_active",
        "type",
        "module_id",
        "created_at",
        "updated_at",
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];
    public static function transform($item)
    {
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->icon = $item->icon;
        $transaction->table_db = $item->table_db;
        $transaction->field_name = $item->field_name;
        $transaction->field_value = $item->field_value;
        $transaction->message = $item->message;
        $transaction->type = $item->type;
        $transaction->module_id = $item->module_id;
        $transaction->is_active = ($item->is_active == 1) ? "Active" : "Blocked";
        $transaction->deleted_at = $item->deleted_at;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["name"] = $item->name;
        $transaction["icon"] = $item->icon;
        $transaction["table_db"] = $item->table_db;
        $transaction["field_name"] = $item->field_name;
        $transaction["field_value"] = $item->field_value;
        $transaction["message"] = $item->message;
        $transaction["type"] = $item->type;
        $transaction["module_id"] = $item->module_id;
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



    public function slugable()
    {
        $table_name = SELF::getTable();
        return $this->hasOne(Slugable::class, "row_id", "id")->where("table_name", $table_name);
    }


}
