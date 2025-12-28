<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class MaterialControleSituacaoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'anterior_material_situacao_id' => ['required', 'different:atual_material_situacao_id'],
            'atual_material_situacao_id' => ['required', 'different:anterior_material_situacao_id'],

            'anterior_estoque_local_id' => ['required', 'different:atual_estoque_local_id'],
            'atual_estoque_local_id' => ['nullable', 'different:anterior_estoque_local_id']
        ];
    }

    public function messages()
    {
        return [
            'atual_material_situacao_id.required' => 'A Situação Alterar é obrigatória.',
            'atual_material_situacao_id.different' => 'A Situação Alterar deve ser diferente da Situação Atual.',
            'anterior_material_situacao_id.required' => 'A Situação Atual é obrigatória.',
            'anterior_material_situacao_id.different' => 'A Situação Atual deve ser diferente da Situação Alterar.',
            'anterior_estoque_local_id.required' => 'O Estoque Local Atual é obrigatório.',
            'anterior_estoque_local_id.different' => 'O Estoque Local Atual deve ser diferente do Estoque Local Alterar.',
            'atual_estoque_local_id.different' => 'O Estoque Local Alterar deve ser diferente do Estoque Local Atual.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'message' => 'Erro de validação',
            'code' => 2020,
            'validation' => $validator->errors(),
            'content' => []
        ], 200));
    }
}
