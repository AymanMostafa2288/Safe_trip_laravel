<?php

namespace App\Http\Requests\frontend\website;

use Illuminate\Foundation\Http\FormRequest;

class CompanyDataRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "logo" => "nullable|image|mimes:png,jpg,jpeg",
            "name" => "required|min:2|max:255",
            "email" => "required|email",
            "hotline" => "required",
            "head_office" => "nullable",
            "about_company" => "nullable",
            "account_id" => "required",
        ];
    }
}
