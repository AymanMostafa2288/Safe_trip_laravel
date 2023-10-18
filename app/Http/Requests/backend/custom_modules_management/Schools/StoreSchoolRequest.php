<?php

namespace App\Http\Requests\backend\custom_modules_management\Schools;

use App\Enum\ActiveStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSchoolRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id;
        return [
            "logo"      => "required|image|mimes:png,jpg,jpeg",
            "name_ar"      => "required",
            "name_en"      => "required",
            "phone"     => "required|unique:bus_schools,phone,NULL,id,deleted_at,NULL",
            "email"     => "required|unique:bus_schools,email,NULL,id,deleted_at,NULL|email:rfc,dns",
            "address"   => "required",
            "location"  => "required",
            "about"     => "nullable",
            "is_active" => "required|".Rule::in(ActiveStatusEnum::options()),
        ];
    }

}
