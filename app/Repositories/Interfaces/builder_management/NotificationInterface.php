<?php
namespace App\Repositories\Interfaces\builder_management;

interface NotificationInterface{
public function data($request,$id="*");
public function save($request,$id="");
public function delete($id);
public function delete_multi($ids);
}
