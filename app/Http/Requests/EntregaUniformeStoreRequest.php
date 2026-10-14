<?php

namespace App\Http\Requests;

use App\Models\EntregaUniforme;
use Illuminate\Foundation\Http\FormRequest;

class EntregaUniformeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        // Número da Entrega
        $ano = date('Y');

        $ultimoNumero = EntregaUniforme::where('numero_entrega', 'like', $ano . '%')->orderByDesc('numero_entrega')->value('numero_entrega');

        if ($ultimoNumero) {
            $sequencia = (int) substr($ultimoNumero, 4, 6);
            $sequencia++;
        } else {
            $sequencia = 1;
        }

        $numeroEntrega = $ano . str_pad($sequencia, 6, '0', STR_PAD_LEFT);

        $this->merge(['numero_entrega' => $numeroEntrega]);
    }

    public function rules()
    {
        return [
            'tomador_servico_cliente_id' => ['nullable', 'integer'],
            'tomador_servico_cliente_nome' => ['nullable', 'required_if:tomador_servico_cliente_id,!=,""', 'string'],
            'funcao_id' => ['nullable', 'integer'],
            'funcao_nome' => ['nullable', 'required_if:funcao_id,!=,""', 'string'],
            'numero_entrega' => ['required', 'digits:10'],
            'uniformes' => ['required', 'array', 'min:1'],
            'data_entrega' => ['nullable', 'date_format:d/m/Y']
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
            'numero_entrega.required' => 'O Número da Entrega é requerido.',
            'numero_entrega.digits' => 'O Número da Entrega deve ter exatamente 10 dígitos.',
            'uniformes.required' => 'Os uniformes são requeridos.',
            'uniformes.array' => 'Os uniformes devem ser enviados em formato de lista.',
            'uniformes.min' => 'É necessário informar pelo menos um uniforme.',
            'data_entrega.date_format' => 'A Data da Entrega não é uma data válida.'
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
