<?php

namespace App\Models;

use App\Models\Main;
use App\Models\Admin;

class Task extends Main
{
    protected $table = "install_tasks";
    protected $fillable = [
        "title",
        "status",
        "images",
        "description",
        "solved_at",
        "priority",
        "type",
        "board_id",
        "admin_id",
        "admin_to",
        "finished_at",
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
        $transaction->title = $item->title;
        $transaction->status = $item->status;
        $transaction->images = $item->images;
        $transaction->description = $item->description;
        $transaction->solved_at = $item->solved_at;
        $transaction->priority = $item->priority;
        $transaction->type = $item->type;
        $transaction->board_id = $item->board_id;
        $transaction->admin_id = $item->admin_id;
        $transaction->admin_to = $item->admin_to;
        $transaction->finished_at = ($item->finished_at)?date("Y-m-d H:i:s", strtotime($item->finished_at)):null;

        $transaction->createdBy = ($item->created_by) ? Admin::transform($item->created_by) : [];
        $transaction->createdTo = ($item->created_to) ? Admin::transform($item->created_to) : [];
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }

    public static function transformArray($item)
    {
        $transaction = [];
        $transaction["id"] = $item->id;
        $transaction["title"] = $item->title;
        $transaction["status"] = $item->status;
        $transaction["images"] = $item->images;
        $transaction["description"] = $item->description;
        $transaction["solved_at"] = $item->solved_at;
        $transaction["priority"] = $item->priority;
        $transaction["type"] = $item->type;
        $transaction["board_id"] = $item->board_id;
        $transaction["admin_id"] = $item->admin_id;
        $transaction["admin_to"] = $item->admin_to;
        $transaction["finished_at"] = ($item->finished_at)?date("Y-m-d H:i:s", strtotime($item->finished_at)):null;

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


    public function created_by(){
        $table_name = SELF::getTable();
        return $this->belongsTo(Admin::class, "admin_id", "id");
    }
    public function created_to(){
        $table_name = SELF::getTable();
        return $this->belongsTo(Admin::class, "admin_to", "id");
    }
}
