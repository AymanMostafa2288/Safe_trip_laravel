<?php

namespace App\Http\Requests\backend\custom_modules_management\Students;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreStudentRequest extends FormRequest
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
            "name"      => "required",
            "family_id" => "required|exists:bus_families,id",
            "code"      => "required|unique:bus_students,code,NULL,id,deleted_at,NULL",
            "phone"     => "required|unique:bus_students,phone,NULL,id,deleted_at,NULL",
            "gander"    => "required|".Rule::in(GanderEnum::options()),
            "is_active" => "required|".Rule::in(ActiveStatusEnum::options()),
            "address"   => "nullable",
            "note"      => "nullable",
        ];
    }

}
