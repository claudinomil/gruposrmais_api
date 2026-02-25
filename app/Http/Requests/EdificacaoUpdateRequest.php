<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EdificacaoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'cliente_id' => ['required'],
            'name' => ['required'],
            'pavimentos' => ['required', 'integer', 'min:1'],
            'mezaninos' => ['required', 'integer', 'min:0'],
            'coberturas' => ['required', 'integer', 'min:0'],
            'areas_tecnicas' => ['required', 'integer', 'min:0'],
            'altura' => ['required', 'regex:/^\d{1,3}(\.\d{3})*(,\d{2})$/'],
            'area_total_construida' => ['required', 'regex:/^\d{1,3}(\.\d{3})*(,\d{2})$/'],
            'lotacao' => ['required', 'integer', 'min:0'],
            'carga_incendio' => ['required', 'integer', 'min:0'],
            'incendio_risco_id' => ['required'],
            'edificacao_classificacao_id' => ['required'],
            'grupo' => ['required'],
            'divisao' => ['required'],
            'ocupacao_uso' => ['required'],
            'descricao' => ['required'],
        ];

        // ---- Regras dinâmicas ----
        $grupos = [
            'pavimentos',
            'mezaninos',
            'coberturas',
            'areas_tecnicas'
        ];

        foreach ($grupos as $grupo) {
            $total = (int) $this->input($grupo, 0);

            for ($i = 1; $i <= $total; $i++) {
                $rules["nivel_nome_{$grupo}_{$i}"] = ['required'];
                $rules["nivel_area_construida_{$grupo}_{$i}"] = ['regex:/^\d{1,3}(\.\d{3})*(,\d{2})$/'];
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = [
            'cliente_id.required' => 'Cliente é requerido.',
            'name.required' => 'Nome é requerido.',
            'pavimentos.required' => 'Pavimentos é requerido.',
            'pavimentos.integer' => 'Pavimentos tem que ser um número inteiro.',
            'pavimentos.min' => 'Pavimentos tem que ser no mínimo 1(um).',
            'mezaninos.required' => 'Mezaninos é requerido.',
            'mezaninos.integer' => 'Mezaninos tem que ser um número inteiro.',
            'mezaninos.min' => 'Mezaninos tem que ser no mínimo 0(zero).',
            'coberturas.required' => 'Coberturas é requerido.',
            'coberturas.integer' => 'Coberturas tem que ser um número inteiro.',
            'coberturas.min' => 'Coberturas tem que ser no mínimo 0(zero).',
            'areas_tecnicas.required' => 'Áreas Técnicas é requerido.',
            'areas_tecnicas.integer' => 'Áreas Técnicas tem que ser um número inteiro.',
            'areas_tecnicas.min' => 'Áreas Técnicas tem que ser no mínimo 0(zero).',
            'altura.required' => 'Altura é requerido.',
            'altura.regex' => 'Altura tem que ser um valor decimal.',
            'area_total_construida.required' => 'Área Total Construída é requerido.',
            'area_total_construida.regex' => 'Área Total Construída tem que ser um valor decimal.',
            'lotacao.required' => 'Lotação é requerido.',
            'lotacao.integer' => 'Lotação tem que ser um número inteiro.',
            'lotacao.min' => 'Lotação tem que ser no mínimo 0(zero).',
            'carga_incendio.required' => 'Carga Incêndio é requerido.',
            'carga_incendio.integer' => 'Carga Incêndio tem que ser um número inteiro.',
            'carga_incendio.min' => 'Carga Incêndio tem que ser no mínimo 0(zero).',
            'incendio_risco_id.required' => 'Risco Incêndio é requerido.',
            'edificacao_classificacao_id.required' => 'Classificação Edificação é requerido.',
            'grupo.required' => 'Grupo é requerido.',
            'divisao.required' => 'Divisão é requerido.',
            'ocupacao_uso.required' => 'Ocupação é requerido.',
            'descricao.required' => 'Descrição é requerido.',
        ];

        // ---- Mensagens dinâmicas ----
        $grupos = [
            'pavimentos' => 'Pavimento',
            'mezaninos' => 'Mezanino',
            'coberturas' => 'Cobertura',
            'areas_tecnicas' => 'Área Técnica'
        ];

        foreach ($grupos as $grupo => $label) {
            $total = (int) $this->input($grupo, 0);

            for ($i = 1; $i <= $total; $i++) {
                $messages["nivel_nome_{$grupo}_{$i}.required"] = "Nome do Nível {$label} {$i} é requerido.";
                $messages["nivel_area_construida_{$grupo}_{$i}.regex"] = "Área Total Construida do Nível {$label} {$i} tem que ser um valor decimal.";
            }
        }

        return $messages;
    }

    // Outras Regras
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // 1️⃣ Validação de igualdade de áreas -------------------------------
            $areaTotal = $this->input('area_total_construida');
            $areaNiveis = $this->input('area_total_construida_niveis');

            if ($areaTotal !== $areaNiveis) {
                $validator->errors()->add(
                    'area_total_construida_niveis',
                    'O campo "Área Total Construída dos Níveis" deve ser igual ao campo "Área Total Construída".'
                );
            }

            // 2️⃣ Validação de nomes duplicados -------------------------------
            $grupos = ['pavimentos', 'mezaninos', 'coberturas', 'areas_tecnicas'];
            $nomes = [];
            $duplicado = false;

            foreach ($grupos as $grupo) {
                $total = (int) $this->input($grupo, 0);

                for ($i = 1; $i <= $total; $i++) {
                    $campoNome = "nivel_nome_{$grupo}_{$i}";
                    $valor = trim(strtolower($this->input($campoNome)));

                    if ($valor !== '') {
                        if (in_array($valor, $nomes)) {
                            $duplicado = true;
                            break 2; // já achou duplicado, pode sair
                        } else {
                            $nomes[] = $valor;
                        }
                    }
                }
            }

            if ($duplicado) {
                $validator->errors()->add(
                    'niveis',
                    'Existem nomes de níveis duplicados entre Pavimentos, Mezaninos, Coberturas e Áreas Técnicas.'
                );
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
