<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MaterialMovimentacaoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        //     'fornecedor_id' => ['required']





        //     'material_entrada_item_id',
        // 'origem_estoque_local_id',
        // 'destino_estoque_local_id',
        // 'tipo',
        // 'quantidade',
        // 'data_movimentacao',
        // 'observacoes'






        ];
    }

    public function messages()
    {
        return [
            // 'fornecedor_id.required' => 'O Fornecedor é requerido.'
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
