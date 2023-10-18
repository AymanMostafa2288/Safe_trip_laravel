<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\App;

class Main extends Model
{
    protected static $lang;

    // public function __construct(array $attributes = [])
    // {
    //     parent::__construct($attributes);
    //     if (strpos(url()->full(), '/en') !== false) {
    //          self::$lang = 'en';
    //     }elseif(strpos(url()->full(), '/ar') !== false){
    //         self::$lang = 'ar';
    //     }else{
    //         if (!array_key_exists('Lang_Sys',$_COOKIE)) {
    //             self::$lang =  !cache()->has('configrations') ? 'en' : main_language();
    //         } else {
    //             self::$lang = $_COOKIE['Lang_Sys'];
    //         }
    //     }

    //     \App::setLocale(self::$lang);
    // }

    public static function transformCollection($items, $type = null, $name = false,$value=false,$select='*')
    {
        $transformers = array();
        if ($type == null) {
            $transform = 'transform';
        } else {
            $transform = 'transform' . $type;
        }
        if (!empty($items)) {
            foreach ($items as $item) {
                if($type=='Custom'){
                    $transformers[] = self::$transform($item,$select);
                }else{
                    if($name!==false && $value!==false) {
                        $row=self::$transform($item);
                        $transformers[$row->$name]=$row->$value;
                    }elseif($name==false && $value!==false){
                        $row=self::$transform($item);
                        $transformers[]=$row->$value;
                    }else{
                        $transformers[] = self::$transform($item);
                    }
                }
            }
        }
        return $transformers;
    }
}
