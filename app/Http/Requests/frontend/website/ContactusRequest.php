<?php

namespace App\Http\Requests\frontend\website;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class ContactusRequest extends FormRequest
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
            "name" => "required",
            "email" => "required|email",
            "phone" => "required",
            "title" => "required",
            "message" => "required",
            'g-recaptcha-response' => ['required', new Recaptcha]
        ];
    }
    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Please ensure that you are a human!'
        ];
    }
}
