<?php
namespace App\Repositories\Interfaces\builder_management;

interface ModuleInterface
{
    public function data($request,$id='*',$field_name='');
    public function store($request); 
    public function update($request,$id); 
    public function delete($id);

    public function create_repository_structures($name,$folder_name,$model_name,$route_name,$controller_name,$module_id);
    public function delete_repository_structures($name,$folder_name,$model_name,$route_name,$controller_name,$module_id);
    
}
