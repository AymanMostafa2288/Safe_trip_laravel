<?php
namespace App\Repositories\Interfaces\builder_management;
interface ChartInterface{
    public function data($request,$id='*',$field_name='');
    public function store($request);
    public function delete($id);
}
?>
