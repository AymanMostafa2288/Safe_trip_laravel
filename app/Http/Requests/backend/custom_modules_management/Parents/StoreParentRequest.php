<?php

namespace App\Http\Requests\backend\custom_modules_management\Parents;

use App\Enum\ActiveStatusEnum;
use App\Enum\Custom\GanderEnum;
use App\Enum\Custom\ParentRelations;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class StoreParentRequest extends FormRequest
{
    public function authorize(){
        return true;
    }

    public function rules(){

        return [
            "name"                       => "required",
            "code"                       => "required|unique:bus_families,code,NULL,id,deleted_at,NULL",
            "is_active"                  => "required|".Rule::in(ActiveStatusEnum::options()),
            "family_members"             => "required|array",
            "family_members.name.*"      => "required",
            "family_members.email.*"     => "required|email|distinct|unique:bus_members,email,NULL,id,deleted_at,NUL",
            "family_members.password.*"  => "required",
            "family_members.phone.*"     => "required|distinct|unique:bus_members,phone,NULL,id,deleted_at,NUL",
            "family_members.gander.*"    => "required|".Rule::in(GanderEnum::options()),
            "family_members.relation.*"  => "required|".Rule::in(ParentRelations::options()),
            "family_members.is_active.*" => "required|".Rule::in(ActiveStatusEnum::options()),

        ];
    }

}
