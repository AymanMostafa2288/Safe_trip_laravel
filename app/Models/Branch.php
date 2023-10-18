<?php
namespace App\Models;


class Branch extends Main
{
    protected $table = "install_branches";
    protected $fillable = [
        'name',
        'phone',
        'address',
        'note',
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
        $transaction->phone = $item->phone;
        $transaction->address = $item->address;
        $transaction->note = $item->note;
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['phone'] = $item->phone;
        $transaction['address'] = $item->address;
        $transaction['note'] = $item->note;
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
