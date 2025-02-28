<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PropostaUpdateRequest extends FormRequest
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
            'data_proposta' => ['nullable'],
            'data_proposta_extenso' => ['nullable'],
            'numero_proposta' => ['nullable'],
            'cliente_id' => ['required', 'integer', 'numeric'],
            'cliente_nome' => ['nullable'],
            'cliente_logradouro' => ['nullable'],
            'cliente_bairro' => ['nullable'],
            'cliente_cidade' => ['nullable'],
            'aos_cuidados' => ['nullable'],
            'texto_acima_tabela_servico' => ['nullable'],
            'porcentagem_desconto' => ['nullable'],
            'valor_desconto' => ['nullable'],
            'valor_desconto_extenso' => ['nullable'],
            'valor_total' => ['nullable'],
            'valor_total_extenso' => ['nullable'],
            'forma_pagamento' => ['nullable'],
            'paragrafo_1' => ['nullable'],
            'paragrafo_2' => ['nullable'],
            'paragrafo_3' => ['nullable'],
            'paragrafo_4' => ['nullable'],
            'paragrafo_5' => ['nullable'],
            'paragrafo_6' => ['nullable'],
            'paragrafo_7' => ['nullable'],
            'paragrafo_8' => ['nullable'],
            'paragrafo_9' => ['nullable'],
            'paragrafo_10' => ['nullable']
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'O Cliente é requerido.',
            'cliente_id.integer' => 'O Cliente deve ser um ítem da lista.',
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
