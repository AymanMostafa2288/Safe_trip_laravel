<?php 
namespace App\Repositories\Interfaces\database_management;

interface SettingInterface{
	
	public function set_env($key,$value);
}