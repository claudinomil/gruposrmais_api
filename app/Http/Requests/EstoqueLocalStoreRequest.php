<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstoqueLocalStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'estoque_id' => ['required'],
            'name' => ['required'],
            'empresa_id' => ['required_if:estoque_id,1', 'nullable', 'integer'],
            'cliente_id' => ['required_if:estoque_id,2', 'nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'estoque_id.required' => 'O campo Estoque é obrigatório.',
            'name.required' => 'O Nome é obrigatório.',
            'empresa_id.required_if' => 'O campo Empresa é obrigatório quando o Estoque for "Empresa".',
            'cliente_id.required_if' => 'O campo Cliente é obrigatório quando o Estoque for "Cliente".',
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
