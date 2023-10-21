<?php

namespace App\Http\Requests\backend\custom_modules_management\Routes;

use App\Enum\ActiveStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRouteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id;
        return [
            "id"                           => "required",
            "school_id"                    => "required|exists:bus_schools,id",
            "name_ar"                      => "required",
            "name_en"                      => "required",
            "address_to"                   => "required",
            "date_to"                      => "required",
            "date_from"                    => "required",
            "location"                     => "required",
            "is_active"                    => "required|".Rule::in(ActiveStatusEnum::options()),
        ];
    }

}
