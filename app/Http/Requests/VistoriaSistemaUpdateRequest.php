<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VistoriaSistemaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'data_prevista' => ['nullable', 'date_format:d/m/Y'],
            'hora_prevista' => ['nullable', 'date_format:H:i:s'],
            'data_conclusao' => ['nullable', 'date_format:d/m/Y'],
            'hora_conclusao' => ['nullable', 'date_format:H:i:s'],
            'data_finalizacao' => ['nullable', 'date_format:d/m/Y'],
            'hora_finalizacao' => ['nullable', 'date_format:H:i:s']
        ];
    }

    public function messages()
    {
        return [
            'data_prevista.date_format' => 'A Data prevista não é uma data válida.',
            'hora_prevista.date_format' => 'A Hora prevista não é uma hora válida.',
            'data_conclusao.date_format' => 'A Data conclusão não é uma data válida.',
            'hora_conclusao.date_format' => 'A Hora conclusão não é uma hora válida.',
            'data_finalizacao.date_format' => 'A Data finalização não é uma data válida.',
            'hora_finalizacao.date_format' => 'A Hora finalização não é uma hora válida.'
        ];
    }

    //Se precisar customizar a resposta JSON (para API requests)
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'Erro de validação',
            'code' => 2020,
            'validation' => $validator->errors(),
            'content' => []
        ], 200));
    }
}
