<?php

namespace App\Http\Requests\frontend\website;

use Illuminate\Foundation\Http\FormRequest;

class ProfileAccountRequest extends FormRequest
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
            "first_name" => "required|min:2|max:255",
            "last_name" => "required|min:2|max:255",
            "email" => "required|email:rfc,dns",
            "phone" => "required",
            "whatsapp" => "nullable",
            "password" => "nullable",
            "image" => "nullable|image|mimes:png,jpg,jpeg",
        ];
    }
}
