<?php 
namespace App\Repositories\Interfaces\builder_management;

interface CounterInterface{
    public function data($request,$id='*',$field_name='');
    public function store($request); 
    public function update($request,$id); 
    public function delete($id);
}