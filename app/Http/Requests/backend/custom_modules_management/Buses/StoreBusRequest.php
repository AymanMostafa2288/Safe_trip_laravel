<?php

namespace App\Http\Requests\backend\custom_modules_management\Buses;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\BusStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(){

        return [
            "vehicle_number"     => "required|unique:bus_buses,vehicle_number,NULL,id,deleted_at,NULL",
            "passenger_capacity" => "required|integer",
            "status"             => "required|".Rule::in(BusStatusEnum::options()),
            "vehicle_license"    => "required",
            "color_code"         => "required",
            "is_active"          => "required|".Rule::in(ActiveStatusEnum::options()),
        ];
    }

}
