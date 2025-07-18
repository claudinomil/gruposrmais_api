<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteExecutivoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cliente_id' => ['required', 'integer'],
            'executivo_nome' => ['required'],
            'executivo_funcao' => ['required'],
            'nome_profissional' => ['required', 'min:3']
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'O Cliente é requerido.',
            'cliente_id.integer' => 'O Cliente deve ser um ítem da lista.',
            'executivo_nome.required' => 'O Nome é requerido.',
            'executivo_funcao.required' => 'A Função é requerido.',
            'nome_profissional.required' => 'O Nome Profissional é requerido.',
            'nome_profissional.min' => 'O Nome Profissional deve ter pelo menos 3 caracteres.'
        ];
    }

    // Se precisar customizar a resposta JSON (para API requests)
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
