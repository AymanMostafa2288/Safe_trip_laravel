<?php

namespace App\Models;

use App\Models\Main;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContactUs extends Main
{
    use SoftDeletes;
    protected $table = "install_contacts";
    protected $fillable = [
        "name",
        "email",
        "phone",
        "title",
        "message",
        "is_active",
        "created_at", "updated_at",
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];
    public static function transform($item)
    {
        $field_translate = static::translate($item->id);
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->email = $item->email;
        $transaction->phone = $item->phone;
        $transaction->title = $item->title;
        $transaction->message = $item->message;
        $transaction->is_active = ($item->is_active == 1) ? "Active" : "Blocked";
        $transaction->deleted_at = $item->deleted_at;
        $transaction->translate = $field_translate;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $field_translate = static::translate($item->id);
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["name"] = $item->name;
        $transaction["email"] = $item->email;
        $transaction["phone"] = $item->phone;
        $transaction["title"] = $item->title;
        $transaction["message"] = $item->message;
        $transaction["is_active"] = $item->is_active;
        $transaction["deleted_at"] = $item->deleted_at;
        $transaction["translate"] = $field_translate;
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

    public static function translate($id)
    {
        $model = new ContactUs;
        $table = explode("_", $model->getTable());
        unset($table[0]);
        $field_name = implode("_", $table) . "_id";
        $table_name = $model->getTable() . "_translate";
        $return = [];
        if(Schema::hasTable($table_name)){
            $langs = DB::table($table_name)->where($field_name, $id)->get();
            foreach ($langs as $lang) {
                $return[$lang->lang] = (array)$lang;
            }
        }


        return $return;
    }
}
