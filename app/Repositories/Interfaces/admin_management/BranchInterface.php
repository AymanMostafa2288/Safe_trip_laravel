<?php 
namespace App\Repositories\Interfaces\admin_management;
interface BranchInterface{
    public function data($request,$id="*");
    public function save($request,$id="");
    public function delete($id);
}
?>