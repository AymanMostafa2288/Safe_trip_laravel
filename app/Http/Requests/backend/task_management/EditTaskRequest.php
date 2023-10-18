<?php

namespace App\Http\Requests\backend\task_management;

use Illuminate\Foundation\Http\FormRequest;

class EditTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "title" => "required|min:3|max:255",
            "status" => "required",
            "type" => "required",
            "images" => "nullable",
            "images.*" => "image|mimes:png,jpg,jpeg",
            "description" => "nullable",
        ];
    }
}
