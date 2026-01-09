<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class ProdutoMovimentacaoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'origem_estoque_local_id' => ['required', 'integer', 'different:destino_estoque_local_id'],
            'destino_estoque_local_id' => ['required', 'integer', 'different:origem_estoque_local_id'],
            'produtos_entradas_itens' => ['required', 'array', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            'origem_estoque_local_id.required' => 'Origem Local é obrigatório.',
            'origem_estoque_local_id.different' => 'Origem Local não pode ser igual ao Destino Local.',

            'destino_estoque_local_id.required' => 'Destino Local é obrigatório.',
            'destino_estoque_local_id.different' => 'Destino Local não pode ser igual à Origem Local.',

            'produtos_entradas_itens.required' => 'Nenhum Produto foi selecionado para Movimentação.',
            'produtos_entradas_itens.array' => 'O formato de Materiais selecionados é inválido.',
            'produtos_entradas_itens.min' => 'Selecione pelo menos um Produto.',
            'produtos_entradas_itens.*.integer' => 'Produto selecionado inválido.'
        ];
    }

    /**
     * Validação customizada: verifica se todos os produtos pertencem ao estoque de origem.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $origemId = $this->input('origem_estoque_local_id');
            $produtos = $this->input('produtos_entradas_itens', []);

            if (!empty($produtos) && $origemId) {
                // Busca todos os produtos que NÃO pertencem ao estoque de origem
                $invalidos = DB::table('produtos_entradas_itens')
                    ->whereIn('id', $produtos)
                    ->where('estoque_local_id', '!=', $origemId)
                    ->pluck('id')
                    ->toArray();

                if (!empty($invalidos)) {
                    $validator->errors()->add(
                        'produtos_entradas_itens',
                        'Alguns produtos não pertencem ao Estoque de Origem informado.'
                    );
                }
            }
        });
    }

    /**
     * Customiza resposta JSON da validação.
     */
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
