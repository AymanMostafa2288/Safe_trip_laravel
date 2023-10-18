<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enum extends Main
{

    protected $table = 'install_codes';
    protected $fillable = [
        'name',
        'values',
    ];
    protected $hidden = [];
    protected $casts = [
        'id'=>'integer',
        'created_at'=>'datetime',
    ];
    public $timestamps = true;
    protected $attributes = [];


    public static function transform($item){
        if(!$item){
            return null;
        }
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->values = $item->values;
        $transaction->created_at = date('Y-m-d H:i:s',strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        if(!$item){
            return [];
        }
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['values'] = $item->values;
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

