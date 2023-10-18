<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Code extends Main
{

    protected $table = 'install_codes';
    protected $fillable = [
        'name',
        'enum_body',
        'created_at',
        'updated_at',
    ];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];


    public static function transform($item){
        if(!$item){
            return null;
        }
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->enum_body = $item->enum_body;
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
        $transaction['enum_body'] = $item->enum_body;
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
    public function parent(){
        return $this->belongsTo(SELF::class,'code_id','id');
    }

    public function child(){
        return $this->hasMany(SELF::class,'id','code_id');
    }
}
