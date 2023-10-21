<?php

namespace App\Http\Requests\backend\custom_modules_management\Routes;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
use App\Enum\Custom\ParentRelations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRouteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id;
        return [
            "school_id"                    => "required|exists:bus_schools,id",
            "name_ar"                      => "required",
            "name_en"                      => "required",
            "address_to"                   => "required",
            "location"                  => "required",
            "date_to"                      => "required",
            "date_from"                    => "required",
            "is_active"                    => "required|".Rule::in(ActiveStatusEnum::options()),
            "route_sign"                   => "required|array",
            "route_sign.bus_id.*"          => "required|exists:bus_buses,id",
            "route_sign.driver_id.*"       => "required|exists:bus_workers,id",
            "route_sign.supervisor_id.*"   => "required|exists:bus_workers,id",
            "route_sign.go_start_time.*"   => "required|distinct",
            "route_sign.go_end_time.*"     => "required|distinct",
            "route_sign.back_start_time.*" => "required|distinct",
            "route_sign.back_end_time.*"   => "required|distinct",
        ];
    }


}
