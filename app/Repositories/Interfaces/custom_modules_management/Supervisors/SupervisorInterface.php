<?php
namespace App\Repositories\Interfaces\custom_modules_management\Supervisors;

interface SupervisorInterface{
public function data($request,$id="*");
public function save($request,$id="");
public function delete($id);
public function delete_multi($ids);
}
