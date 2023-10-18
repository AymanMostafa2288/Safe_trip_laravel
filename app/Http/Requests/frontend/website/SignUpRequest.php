<?php

namespace App\Http\Requests\frontend\website;

use Illuminate\Foundation\Http\FormRequest;

class SignUpRequest extends FormRequest
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
            "first_name" => "required",
            "last_name" => "required",
            "email" => "required|email|unique:osoule_account",
            "phone" => "required|unique:osoule_account",
            "whatsapp" => "nullable|unique:osoule_account",
            "type"=>"required",
            "name"=>"required_if:type,in:broker,developer",
            "password" => "required",
        ];
    }
}
