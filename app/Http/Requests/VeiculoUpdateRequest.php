<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeiculoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'veiculo_marca_id' => ['required', 'integer'],
            'veiculo_modelo_id' => ['required', 'integer'],
            'placa' => ['required', Rule::unique('veiculos')->ignore($this->id)],
            'renavam' => ['nullable', Rule::unique('veiculos')->ignore($this->id)],
            'chassi' => ['nullable', Rule::unique('veiculos')->ignore($this->id)],
            'ano_modelo' => ['nullable', 'integer'],
            'ano_fabricacao' => ['nullable', 'integer']
        ];
    }

    public function messages()
    {
        return [
            'veiculo_marca_id.required' => 'A Marca é requerida.',
            'veiculo_marca_id.integer' => 'A Marca deve ser um ítem da lista.',
            'veiculo_modelo_id.required' => 'O Modelo é requerida.',
            'veiculo_modelo_id.integer' => 'O Modelo deve ser um ítem da lista.',
            'placa.unique' => 'A Placa já existe.',
            'renavam.unique' => 'O Renavam já existe.',
            'chassi.unique' => 'O Chassi já existe.',
            'ano_modelo.integer' => 'O Ano Modelo deve ser um numero de 4 dígitos.',
            'ano_fabricacao.integer' => 'O Ano Fabricação deve ser um numero de 4 dígitos.'
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
