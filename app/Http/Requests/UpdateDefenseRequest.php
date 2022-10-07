<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDefenseRequest extends FormRequest
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
            "localID" => "required|numeric",
            "data" => "required|date_format:d/m/Y",
            "horario" => "required|date_format:H:i",
            "link" => "sometimes",
        ];
    }

    public function messages()
    {
        return [
            "localID.required" => "É necessário informar o local da defesa.",
            "data.required" => "É necessário informar a data da defesa.",
            "data.date_format" => "A data da defesa precisa estar no formato dd/mm/YYYY.",
            "horario.required" => "É necessário informar o horário da defesa.",
            "horario.date_format" => "O horário da defesa precisa estar no formato HH:ii.",
        ];
    }
}
