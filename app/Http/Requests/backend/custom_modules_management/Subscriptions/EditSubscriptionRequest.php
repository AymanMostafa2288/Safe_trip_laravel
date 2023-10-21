<?php

namespace App\Http\Requests\backend\custom_modules_management\Subscriptions;

use Illuminate\Foundation\Http\FormRequest;

class EditSubscriptionRequest extends FormRequest
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
            "family_id" => "required|exists:bus_families,id",
            "package_id" => "required|exists:bus_packages,id",
            "count_of_price" => "required",
            "price" => "required|integer",
        ];
    }

}
