<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntregaUniformeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tomador_servico_cliente_id' => ['nullable', 'integer'],
            'tomador_servico_cliente_nome' => ['nullable', 'required_if:tomador_servico_cliente_id,!=,""', 'string'],
            'funcao_id' => ['nullable', 'integer'],
            'funcao_nome' => ['nullable', 'required_if:funcao_id,!=,""', 'string'],
            'uniformes' => ['required', 'array', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            'tomador_servico_cliente_id.integer' => 'O Tomador de Serviço deve ser um item da lista.',
            'tomador_servico_cliente_nome.required_if' => 'O nome do Tomador de Serviço é requerido quando o Tomador de Serviço for informado.',
            'tomador_servico_cliente_nome.string' => 'O nome do Tomador de Serviço deve ser um texto.',
            'funcao_id.integer' => 'A Função deve ser um item da lista.',
            'funcao_nome.required_if' => 'O nome da Função é requerido quando a Função for informada.',
            'funcao_nome.string' => 'O nome da Função deve ser um texto.',
            'uniformes.required' => 'Os uniformes são requeridos.',
            'uniformes.array' => 'Os uniformes devem ser enviados em formato de lista.',
            'uniformes.min' => 'É necessário informar pelo menos um uniforme.'
        ];
    }

    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException(
            $validator,
            response()->json([
                'message' => 'Erro de validação',
                'code' => 2020,
                'validation' => $validator->errors(),
                'content' => []
            ], 200)
        );
    }
}
