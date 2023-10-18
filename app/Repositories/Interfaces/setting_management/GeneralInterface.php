<?php
namespace App\Repositories\Interfaces\setting_management;

interface GeneralInterface{

	public function store($request);

	public function data($field_name='');
}
