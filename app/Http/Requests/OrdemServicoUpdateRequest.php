<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrdemServicoUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ordem_servico_tipo_id' => ['required'],
            'data_prevista' => ['nullable', 'date_format:d/m/Y'],
            'hora_prevista' => ['nullable', 'date_format:H:i:s'],
            'data_conclusao' => ['nullable', 'date_format:d/m/Y'],
            'hora_conclusao' => ['nullable', 'date_format:H:i:s'],
            'data_finalizacao' => ['nullable', 'date_format:d/m/Y'],
            'hora_finalizacao' => ['nullable', 'date_format:H:i:s'],
            'cliente_id' => ['required_if:ordem_servico_tipo_id,2,3'],
            'ordem_servico_prioridade_id' => ['required'],
            'servico_id' => ['required_if:ordem_servico_tipo_id,1,2,3'],
            'destino_cep' => ['required_if:ordem_servico_tipo_id,3'],
            'veiculo_id' => ['required_if:ordem_servico_tipo_id,3'],
            'cliente_executivo_id' => ['required_if:ordem_servico_tipo_id,3'],
            'equipe_funcionario_id' => ['required_if:ordem_servico_tipo_id,3'],
        ];
    }

    public function messages()
    {
        return [
            'ordem_servico_tipo_id.required' => 'O Tipo é requerido.',
            'data_prevista.date_format' => 'A Data prevista não é uma data válida.',
            'hora_prevista.date_format' => 'A Hora prevista não é uma hora válida.',
            'data_conclusao.date_format' => 'A Data conclusão não é uma data válida.',
            'hora_conclusao.date_format' => 'A Hora conclusão não é uma hora válida.',
            'data_finalizacao.date_format' => 'A Data finalização não é uma data válida.',
            'hora_finalizacao.date_format' => 'A Hora finalização não é uma hora válida.',
            'cliente_id.required_if' => 'O Cliente é requerido.',
            'ordem_servico_prioridade_id.required' => 'A Prioridade é requerido.',
            'servico_id.required_if' => 'Escolha pelo menos um Serviço.',
            'destino_cep.required_if' => 'Escolha pelo menos um Destino.',
            'veiculo_id.required_if' => 'Escolha pelo menos um Veículo.',
            'cliente_executivo_id.required_if' => 'Escolha pelo menos um Executivo.',
            'equipe_funcionario_id.required_if' => 'Escolha a Equipe.',
        ];
    }

    public function withValidator(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $validator->after(function ($validator) {
            //Serviços ids''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $servicos_ids = $this->input('servico_id', []);
            if (count($servicos_ids) !== count(array_unique($servicos_ids))) {
                $validator->errors()->add('servico_id', 'Os serviços não podem ser repetidos.');
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Serviços nomes''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $servicos_nomes = $this->input('servico_nome', []);
            foreach ($servicos_nomes as $servicos_nome) {
                if ($servicos_nome == '' or $servicos_nome == 0) {
                    $validator->errors()->add('servico_nome', 'Está faltando nome do serviço na grade.');
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Veículos ids''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

//            $veiculos_ids = $this->input('veiculo_id', []);
//            $veiculos_checados = [];
//
//            foreach ($veiculos_ids as $index => $veiculo_id) {
//
//                $validator->errors()->add("veiculo_id", "O veículo com ID {$veiculo_id} está repetido.");
//
//
//                if (in_array($veiculo_id, $veiculos_checados)) {
//                    //$validator->errors()->add("veiculo_id.{$index}", "O veículo com ID {$veiculo_id} está repetido.");
//                } else {
//                    $veiculos_checados[] = $veiculo_id;
//                }
//            }



            $veiculos_ids = $this->input('veiculo_id', []);
            if (count($veiculos_ids) !== count(array_unique($veiculos_ids))) {
                $validator->errors()->add('veiculo_id', 'Os veiculos não podem ser repetidos.');
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Veículos marcas'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $veiculos_marcas = $this->input('veiculo_marca', []);
            foreach ($veiculos_marcas as $veiculos_marca) {
                if ($veiculos_marca == '' or $veiculos_marca == 0) {
                    $validator->errors()->add('veiculo_marca', 'Está faltando marca do veiculo na grade.');
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Cliente Executivos ids''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $cliente_executivos_ids = $this->input('cliente_executivo_id', []);
            if (count($cliente_executivos_ids) !== count(array_unique($cliente_executivos_ids))) {
                $validator->errors()->add('cliente_executivo_id', 'Os executivos não podem ser repetidos.');
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Cliente Executivos nomes''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $cliente_executivos_nomes = $this->input('cliente_executivo_nome', []);
            foreach ($cliente_executivos_nomes as $cliente_executivos_nome) {
                if ($cliente_executivos_nome == '' or $cliente_executivos_nome == 0) {
                    $validator->errors()->add('cliente_executivo_nome', 'Está faltando nome do executivo na grade.');
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Equipe Funcionarios ids'''''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $equipe_funcionarios_ids = $this->input('equipe_funcionario_id', []);
            if (count($equipe_funcionarios_ids) !== count(array_unique($equipe_funcionarios_ids))) {
                $validator->errors()->add('equipe_funcionario_id', 'Os funcionários da equipe não podem ser repetidos.');
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

            //Equipe Funcionarios nomes'''''''''''''''''''''''''''''''''''''''''''''''''''''''
            $equipe_funcionarios_nomes = $this->input('equipe_funcionario_nome', []);
            foreach ($equipe_funcionarios_nomes as $equipe_funcionarios_nome) {
                if ($equipe_funcionarios_nome == '' or $equipe_funcionarios_nome == 0) {
                    $validator->errors()->add('equipe_funcionario_nome', 'Está faltando nome de funcionários da equipe na grade.');
                }
            }
            //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
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
