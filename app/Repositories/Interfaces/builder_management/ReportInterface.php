<?php
namespace App\Repositories\Interfaces\builder_management;

interface ReportInterface
{
    public function data($request,$id='*');
    public function store($request);
    public function update($request,$id);
    public function delete($id);
    public function build_query($main_table,$selects=[],$joins=[],$condtions=[],$groups_by=null,$orders=[],$limits=null);
    public function build_form($condtions=[]);
}
