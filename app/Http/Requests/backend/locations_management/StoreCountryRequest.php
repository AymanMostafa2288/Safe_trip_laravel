<?php

namespace App\Http\Requests\backend\locations_management;

use Illuminate\Foundation\Http\FormRequest;

class StoreCountryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            "name_en" => "required|min:3|max:255",
            "name_ar" => "required|min:3|max:255",
            "note" => "nullable",
            "image" => "required",
        ];
    }
}
