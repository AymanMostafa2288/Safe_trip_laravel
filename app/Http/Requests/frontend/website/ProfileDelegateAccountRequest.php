<?php

namespace App\Http\Requests\frontend\website;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileDelegateAccountRequest extends FormRequest
{
    public $validator = null;

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
            "email" =>  "required|email|unique:osoule_delegates,email",
            "phone" => "required",
            "status" => "required",
            "whatsapp" => "nullable",
            "password" => "nullable",
            "image" => "nullable|image|mimes:png,jpg,jpeg",
        ];
    }
    public function messages()
    {
        return [
            'first_name.required' => 'The First Name is required',
            'last_name.required' => 'The Last Name is required',
            'email.required' => 'The Email is required',
            'email.unique' => ' this email address already exists.',
            'email.email' => ' You Must Enter A Valid Email.',
        ];
    }

}
