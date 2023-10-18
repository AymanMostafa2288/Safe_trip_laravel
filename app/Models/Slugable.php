<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slugable extends Main
{
    use SoftDeletes;
    protected $table = 'install_slug';
    protected $fillable = [
        'slug',
        'table_name',
        'row_id',
        'in_sitemap',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];


    public static function transform($item){
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->slug;
        $transaction->table_name = $item->table_name;
        $transaction->table_name = $item->row_id;
        $transaction->in_sitemap = $item->in_sitemap;
        $transaction->created_at = date('Y-m-d H:i:s',strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['slug'] = $item->slug;
        $transaction['table_name'] = $item->table_name;
        $transaction['row_id'] = $item->row_id;
        $transaction['in_sitemap'] = $item->in_sitemap;
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
