<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            "titulo" => "required",
            "dataInicial" => "required|date_format:d/m/Y|before:dataFinal",
            "dataFinal" => "sometimes|nullable|date_format:d/m/Y",
            "horarioInicial" => "required|date_format:H:i|before:horarioFinal",
            "horarioFinal" => "required|date_format:H:i",
            "local" => "required",
            "url" => "sometimes",
            'gratuito' => 'sometimes|bool',
            'emiteCertificado' => 'sometimes|bool',
            'exigeInscricao' => 'sometimes|bool',
            "nomeOrganizador" => "required",
            "idiomaID" => "required|numeric",
            "modalidadeID" => "required|numeric",
            "tipoID" => "required|numeric",
            "cadastradorID" => "required|numeric",
            'descricao' => 'required|max:8192',
            'anexosIDs' => "sometimes|array",
            'anexosNovos' => "sometimes|array",
            "anexosNovos.*.arquivo" => "required|mimes:jpeg,bmp,png,gif,svg,pdf|max:10240",
        ];
    }
}