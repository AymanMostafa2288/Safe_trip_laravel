<?php

namespace App\Repositories\Interfaces\custom_modules_management\Parents;

interface ParentsInterface{

    public function data($request, $id = "*");

    public function save($request, $id = "");

    public function delete($id);

    public function translate($id);

    public function translate_store($request, $id);

    public function delete_multi($ids);
}
