<?php 
namespace App\Repositories\Interfaces\admin_management;
interface AdminInterface{
    public function data($request,$id="*");
    public function save($request,$id="");
    public function delete($id);
}
?>