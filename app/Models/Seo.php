<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seo extends Main
{
    use SoftDeletes;

    protected $table = 'install_seo';
    protected $fillable = [
        'url',
        'meta_title',
        'meta_desc',
        'meta_canonical',
        'meta_keywords',
        'web_h1',
        'web_h2',
        'web_faqs',
        'web_blog',
        'web_short_links',
        'breadcrumbs',
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
        $transaction->url = $item->url;
        $transaction->meta_title = $item->meta_title;
        $transaction->meta_desc = $item->meta_desc;
        $transaction->meta_canonical = $item->meta_canonical;
        $transaction->meta_keywords = $item->meta_keywords;
        $transaction->web_h1 = $item->web_h1;
        $transaction->web_h2 =$item->web_h2;
        $transaction->web_faqs = $item->web_faqs;
        $transaction->web_blog = $item->web_blog;
        $transaction->web_short_links = $item->web_short_links;
        $transaction->breadcrumbs = $item->breadcrumbs;

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
        $transaction['url'] = $item->url;
        $transaction['meta_title'] = $item->meta_title;
        $transaction['meta_desc'] = $item->meta_desc;
        $transaction['meta_canonical'] = $item->meta_canonical;
        $transaction['meta_keywords'] = $item->meta_keywords;
        $transaction['web_h1'] = $item->web_h1;
        $transaction['web_h2'] = $item->web_h2;
        $transaction['web_faqs'] = $item->web_faqs;
        $transaction['web_blog'] = $item->web_blog;
        $transaction['web_short_links'] = $item->web_short_links;
        $transaction['breadcrumbs'] = $item->breadcrumbs;
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
