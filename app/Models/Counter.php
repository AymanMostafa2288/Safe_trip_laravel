<?php
namespace App\Models;

class Counter extends Main
{
    protected $table = "install_counters";
    protected $fillable = [
        'name',
        'is_active',
        'statement',
        'prams_counters',
        'module_related',
        'report_related',
        'type',
        'icon',
        'ordered',
        'created_at',
        'updated_at',
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
        $transaction->is_active = ($item->is_active==1)?'Active':'Blocked';
        $transaction->statement = $item->statement;
        $transaction->prams_counters = $item->prams_counters;
        $transaction->module_related = $item->module_related;
        $transaction->report_related = $item->report_related;
        $transaction->type = $item->type;
        $transaction->icon = $item->icon;
        $transaction->ordered = $item->ordered;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['is_active'] = $item->is_active;
        $transaction['statement'] = $item->statement;
        $transaction['prams_counters'] = $item->prams_counters;
        $transaction['module_related'] = $item->module_related;
        $transaction['report_related'] = $item->report_related;
        $transaction['type'] = $item->type;
        $transaction['icon'] = $item->icon;
        $transaction['ordered'] = $item->ordered;
        $transaction['created_at'] = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    public static function transformCustom($item,$select){
        if($select=='*'){
            return self::transform($item);
        }else{
            $transaction = new \stdclass();
            foreach ($select as $row) {
                $transaction->$row = $item->$row;
            }

            return $transaction;
        }
    }
}
