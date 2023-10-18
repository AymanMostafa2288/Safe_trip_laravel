<?php
namespace App\Models;

class Language extends Main
{

    protected $table = "install_languages";
    protected $fillable = [
        'name',
        'slug',
        'is_main',
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
        $transaction->slug = $item->slug;
        $transaction->is_main = ($item->is_main==1)?'Main Language':'Sub Language';
        $transaction->created_at = date("Y-m-d H:i:s", strtotime($item->created_at));
        return $transaction;
    }
    public static function transformArray($item)
    {
        $transaction = [];
        $transaction['id'] = $item->id;
        $transaction['name'] = $item->name;
        $transaction['slug'] = $item->slug;
        $transaction['is_main'] = $item->is_main;
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
