<?php
namespace App\Repositories\Interfaces\setting_management;

interface SeoInterface{

    public function data($request,$id="*");
    public function save($request,$id="");
    public function delete($id);
}
