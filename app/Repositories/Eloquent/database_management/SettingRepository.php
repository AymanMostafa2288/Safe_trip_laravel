<?php
namespace App\Repositories\Eloquent\database_management;
use App\Repositories\Interfaces\database_management\SettingInterface;

class SettingRepository implements SettingInterface
{

    public function set_env($key, $value) {
        if($key!='id' || $key!='value'){
            $path = base_path() . '/.env';
            if (file_exists($path)) {
                if (getenv($key)===false) {
                     //set if variable key not exit
                     $file   = file($path);
                     $file[] = "$key=" . $value;
                     file_put_contents($path, $file);
                    if($key==''){

                    }

                } else {

                      //replace variable if key exit
                      file_put_contents($path, str_replace(
                        "$key=" . getenv($key), "$key=" . $value, file_get_contents($path)
                    ));
                }
            }
        }


    }

}
