<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Main
{

    protected $table = 'install_permissions';
    protected $fillable = [
        'name',
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
        $transaction->name = $item->name;
        $transaction->created_at = date('Y-m-d H:i:s',strtotime($item->created_at));
        $transaction->value =(array)json_decode($item->value,true);
        return $transaction;
    }
}
