<?php

namespace App\Repositories\Interfaces\task_management;

interface BoardsInterface
{
    public function data($request, $id = "*");
    public function save($request, $id = "");
    public function delete($id);
    public function delete_multi($ids);
}
