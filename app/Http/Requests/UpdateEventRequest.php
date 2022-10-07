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
            "horarioFinal" => "sometimes|nullable|date_format:H:i",
            "localID" => "required|numeric",
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

    public function messages()
    {
        return [
            "titulo.required" => "É necessário informar o titulo do evento.",
            "dataInicial.required" => "É necessário informar a data inicial do evento.",
            "dataInicial.date_format" => "A data inicial precisa estar no formato dd/mm/YYYY.",
            "dataInicial.before" => "A data inicial precisa ser anterior a data final.",
            "dataFinal.date_format" => "A data final precisa estar no formato dd/mm/YYYY.",
            "horarioInicial.required" => "É necessário informar o horário inicial do evento.",
            "horarioInicial.date_format" => "O horário inicial precisa estar no formato HH:ii.",
            "horarioInicial.before" => "O horário inicial precisa ser anterior ao horário final.",
            "horarioFinal.date_format" => "O horário final precisa estar no formato HH:ii.",
            "localID.required" => "É necessário informar o local do evento.",
            "nomeOrganizador.required" => "É necessário informar o nome do organizador do evento.",
            "idiomaID.required" => "É necessário informar o idioma do evento.",
            "modalidadeID.required" => "É necessário informar a modalidade do evento.",
            "tipoID.required" => "É necessário informar o tipo do evento.",
            "descricao.required" => "É necessário descrever o evento.",
            "descricao.max" => "A descrição do evento deve conter no maximo 8192 caracteres.",
            "anexosNovos.*.arquivo.mimes" => "Os anexos devem ser de uma das seguintes extensões jpeg,bmp,png,gif,svg,pdf.",
            "anexosNovos.*.arquivo.max" => "Os anexos devem ter no máximo 10MB.",
        ];
    }
}
