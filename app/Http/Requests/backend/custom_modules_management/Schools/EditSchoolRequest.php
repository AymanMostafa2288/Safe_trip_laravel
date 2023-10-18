<?php

namespace App\Http\Requests\backend\custom_modules_management\Schools;

use App\Enum\ActiveStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditSchoolRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id;
        return [
            "id"        => "required",
            "logo"      => "nullable|image|mimes:png,jpg,jpeg",
            "name_ar"      => "required",
            "name_en"      => "required",
            "phone"     => "required|unique:bus_schools,phone," . $id . ",id,deleted_at,NULL",
            "email"     => "required|unique:bus_schools,email," . $id . ",id,deleted_at,NULL|email:rfc,dns",
            "address"   => "required",
            "location"  => "required",
            "about"     => "nullable",
            "is_active" => "required|".Rule::in(ActiveStatusEnum::options()),
        ];
    }

}
