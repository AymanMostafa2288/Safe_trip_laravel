<?php

namespace App\Http\Requests\backend\task_management;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "title" => "required",
            "stages" => "nullable",
        ];
    }
}
