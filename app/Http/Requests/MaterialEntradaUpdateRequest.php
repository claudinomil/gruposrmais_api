<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Models\MaterialEntradaItem;

class MaterialEntradaUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fornecedor_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'fornecedor_id.required' => 'O Fornecedor é requerido.'
        ];
    }

    /**
     * Verificação de patrimônios duplicados (internos e no banco)
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Extrai todos os patrimônios enviados
            $patrimonios = array_filter($this->input('mat_material_numero_patrimonio', []));

            if (empty($patrimonios)) {
                return;
            }

            // Verifica se algum patrimônio já existe em outra entrada (exceto a atual)
            $query = MaterialEntradaItem::whereIn('material_numero_patrimonio', $patrimonios);

            // Ignora registros da própria entrada (para não acusar falso positivo)
            $materialEntradaId = $this->route('id') ?? $this->input('id');
            if ($materialEntradaId) {
                $query->where('material_entrada_id', '!=', $materialEntradaId);
            }

            $duplicados = $query->pluck('material_numero_patrimonio')->toArray();

            // Verifica duplicados dentro do próprio request (itens repetidos no formulário)
            $internos = array_diff_assoc($patrimonios, array_unique($patrimonios));

            // Combina duplicados do banco e internos
            $todosDuplicados = array_unique(array_merge($duplicados, $internos));

            if (!empty($todosDuplicados)) {
                // Monta uma mensagem única com quebras de linha
                $mensagem = "Os seguintes números de patrimônio já estão cadastrados:" . PHP_EOL;
                foreach ($todosDuplicados as $pat) {
                    $mensagem .= "- {$pat}" . PHP_EOL;
                }

                $validator->errors()->add('mat_material_numero_patrimonio', trim($mensagem));
            }
        });
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
