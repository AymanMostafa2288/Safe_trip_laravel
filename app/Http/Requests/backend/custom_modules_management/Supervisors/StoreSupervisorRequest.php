<?php

namespace App\Http\Requests\backend\custom_modules_management\Supervisors;
use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSupervisorRequest extends FormRequest
{
public function authorize()
{
return true;
}

 public function rules()
{
$id=request()->id;
    return [
        "logo"            => "nullable|image|mimes:png,jpg,jpeg",
        "code"            => "required|unique:bus_workers,code,NULL,id,deleted_at,NULL",
        "name"            => "required",
        "mobile"          => "required|unique:bus_workers,mobile,NULL,id,deleted_at,NULL",
        "national_id"     => "required|unique:bus_workers,national_id,NULL,id,deleted_at,NULL",
        'note'            => 'nullable',
        "password"        => "required",
        "gander"          => "required|".Rule::in(GanderEnum::options()),
        "is_active"       => "required|".Rule::in(ActiveStatusEnum::options()),
    ];
}

}
