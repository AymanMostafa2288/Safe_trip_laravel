<?php

namespace App\Http\Requests\backend\custom_modules_management\Students;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditStudentRequest extends FormRequest
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
            "name"      => "required",
            "family_id" => "required|exists:bus_families,id",
            "code"      => "required|unique:bus_students,code," . $id . ",id,deleted_at, NULL",
            "phone"     => "nullable | unique:bus_students,phone," . $id . ",id,deleted_at,NULL",
            "gander"    => "required|".Rule::in(GanderEnum::options()),
            "is_active" => "required|".Rule::in(ActiveStatusEnum::options()),
            "address"   => "nullable",
            "note"      => "nullable",
        ];
    }

}
