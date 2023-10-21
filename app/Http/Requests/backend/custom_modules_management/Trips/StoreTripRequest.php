<?php

namespace App\Http\Requests\backend\custom_modules_management\Trips;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id;
        return [
            "route_id" => "required",
            "driver_id" => "required",
            "supervisor_id" => "required",
            "trip_id" => "nullable",
            "bus_id" => "required",
            "status" => "required",
            "day" => "required",
            "time_start" => "required",
            "time_end" => "required",
        ];
    }

}
