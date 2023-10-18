<?php

namespace App\Http\Requests\backend\ticket_support_management;
use Illuminate\Foundation\Http\FormRequest;
class EditContactUsRequest extends FormRequest
{
public function authorize()
{
return true;
}

 public function rules()
{
$id=request()->id;
return [
"name" => "required",
"email" => "required|email:rfc,dns",
"phone" => "required",
"title" => "required",
"message" => "required",
];
}

}
