<?php
namespace App\Models;


class Chart extends Main
{
    protected $table = "install_charts";
    protected $fillable = [
        'name',
        'type',
        'active',
        'width',
        'height',
        'labels',
        'datasate_config',
        'sql_statments',
        'module_related',
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
        $transaction->type = $item->type;
        $transaction->active = $item->active;
        $transaction->width = $item->width;
        $transaction->height = $item->height;
        $transaction->labels = $item->labels;
        $transaction->datasate_config = $item->datasate_config;
        $transaction->sql_statments = $item->sql_statments;
        $transaction->module_related = $item->module_related;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['type'] = $item->type;
        $transaction['active'] = $item->active;
        $transaction['width'] = $item->width;
        $transaction['height'] = $item->height;
        $transaction['labels'] = $item->labels;
        $transaction['datasate_config'] = $item->datasate_config;
        $transaction['sql_statments'] = $item->sql_statments;
        $transaction['module_related'] = $item->module_related;
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
