<?php
namespace App\Repositories\Interfaces\builder_management;

interface ModuleFieldsInterface
{
    public function data($request,$id='*');
    public function save($request,$id='');
    public function delete($id);
}
