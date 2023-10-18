<?php

namespace App\Http\Requests\backend\custom_modules_management\Drivers;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditDriverRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id;
        return [
            "id"              => "required",
            "logo"            => "nullable|image|mimes:png,jpg,jpeg",
            "code"            => "required|unique:bus_workers,code," . $id . ",id,deleted_at,NULL",
            "name"            => "required",
            "mobile"          => "required|unique:bus_workers,mobile," . $id . ",id,deleted_at,NULL",
            "national_id"     => "required|unique:bus_workers,national_id," . $id . ",id,deleted_at,NULL",
            "driving_license" => "required|unique:bus_drivers,driving_license," . $id . ",worker_id,deleted_at,NULL",
            'note'            => 'nullable',
            "password"        => "nullable",
            "gander"          => "required|".Rule::in(GanderEnum::options()),
            "is_active"       => "required|".Rule::in(ActiveStatusEnum::options()),
        ];
    }

}
