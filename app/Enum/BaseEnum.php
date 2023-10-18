<?php
namespace App\Enum;
use Illuminate\Support\Str;

abstract class BaseEnum{
    /**
     * items
     * Get class constants as a cases
     * @return array
     */
    public static function items() : array
    {
        $ref = new \ReflectionClass(static::class);
        return $ref->getConstants();
    }

    /**
     * values
     * @return array
     */
    public static function values(): array
    {
        return array_values(static::items());
    }

    /**
     * values
     * @return array
     */
    public static function options($option='',$reverse=false)
    {
        $values=array_values(static::values());
        $keys=array_keys(static::items());
        $options=[];
        foreach($values as $key=>$value){
            if($reverse)
                $options[$value]=Str::lower($keys[$key]);
            else
                $options[Str::lower($keys[$key])]=$value;
        }
        if($option!=''){
            return $options[$option];
        }
        return $options;
    }
}
