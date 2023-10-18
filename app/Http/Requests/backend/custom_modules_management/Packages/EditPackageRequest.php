<?php

namespace App\Http\Requests\backend\custom_modules_management\Packages;
use Illuminate\Foundation\Http\FormRequest;
class EditPackageRequest extends FormRequest
{
public function authorize()
{
return true;
}

 public function rules()
{
$id=request()->id;
return [
"name_ar" => "required",
"name_en" => "required",
"route_id" => "required",
"count_of_trip" => "required|integer",
"price" => "required|integer",
"note_ar" => "required",
"note_en" => "required",
];
}

}