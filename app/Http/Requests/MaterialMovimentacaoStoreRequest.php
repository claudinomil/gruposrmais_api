<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class MaterialMovimentacaoStoreRequest extends FormRequest
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
            'materiais_entradas_itens' => ['required', 'array', 'min:1'],
            'materiais_entradas_itens.*' => ['integer', 'exists:materiais,id']
        ];
    }

    public function messages()
    {
        return [
            'origem_estoque_local_id.required' => 'Origem Local é obrigatório.',
            'origem_estoque_local_id.different' => 'Origem Local não pode ser igual ao Destino Local.',

            'destino_estoque_local_id.required' => 'Destino Local é obrigatório.',
            'destino_estoque_local_id.different' => 'Destino Local não pode ser igual à Origem Local.',

            'materiais_entradas_itens.required' => 'Nenhum Material foi selecionado para Movimentação.',
            'materiais_entradas_itens.array' => 'O formato de Materiais selecionados é inválido.',
            'materiais_entradas_itens.min' => 'Selecione pelo menos um Material.',
            'materiais_entradas_itens.*.integer' => 'Material selecionado inválido.',
            'materiais_entradas_itens.*.exists' => 'Material selecionado não existe no banco de dados.'
        ];
    }

    /**
     * Validação customizada: verifica se todos os materiais pertencem ao estoque de origem.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $origemId = $this->input('origem_estoque_local_id');
            $materiais = $this->input('materiais_entradas_itens', []);

            if (!empty($materiais) && $origemId) {
                // Busca todos os materiais que NÃO pertencem ao estoque de origem
                $invalidos = DB::table('materiais_entradas_itens')
                    ->whereIn('id', $materiais)
                    ->where('estoque_local_id', '!=', $origemId)
                    ->pluck('id')
                    ->toArray();

                if (!empty($invalidos)) {
                    $validator->errors()->add(
                        'materiais_entradas_itens',
                        'Alguns materiais não pertencem ao Estoque de Origem informado.'
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
