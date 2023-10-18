<?php
namespace App\Models;

class General extends Main
{
    
    protected $table = "install_settings";
    protected $fillable = [];
    protected $hidden = [];
    protected $casts = [];
    public $timestamps = true;
    protected $attributes = [];
    
    public static function transform($item)
    {
        $transaction = new \stdclass();
        $transaction->id = $item->id;
        $transaction->name = $item->name;
        $transaction->value = $item->value;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    
}
