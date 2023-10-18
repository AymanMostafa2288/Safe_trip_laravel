<?php
namespace App\Repositories\Interfaces\ticket_support_management;

interface ContactUsInterface{
public function data($request,$id="*");
public function save($request,$id="");
public function delete($id);
public function translate($id);
public function translate_store($request,$id);
public function delete_multi($ids);
}
