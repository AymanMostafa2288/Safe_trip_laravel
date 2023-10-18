<?php
namespace App\Repositories\Interfaces\database_management;
interface TablesInterface{
    public function index($request,$id='*');
    public function store($request);
    public function create_migration_table();
    public function store_migration_table($request);
    public function delete($id);
    public function genrate_migration_files($table_name);
}
?>
