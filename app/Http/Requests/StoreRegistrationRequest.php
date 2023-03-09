<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "fullName" => "required",
            "nickname" => "required",
            "email" => "required",
            "passport" => "required_if:rg,==,null",
            "rg" => "required_if:passport,==,null",
            "phone" => "required",
            "affiliation" => "required",
            "position" => "required",
            "department" => "required",
            "cep" => "required",
            "address" => "required",
            "city" => "required",
            "state" => "required",
            "country" => "required",
        ];
    }
}
