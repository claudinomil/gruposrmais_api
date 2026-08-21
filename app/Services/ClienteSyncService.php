<?php

namespace App\Services;

use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Genero;
use App\Models\IdentidadeOrgao;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ClienteSyncService
{
    public function insert(Cliente $cliente)
    {
        $this->salvarPrevinir($cliente);
    }

    public function update(Cliente $cliente)
    {
        $this->salvarPrevinir($cliente);
    }

    public function delete(int $id)
    {
        DB::connection('previnir')->table('gsr_clientes')->where('id', $id)->delete();;
    }

    private function salvarPrevinir(Cliente $cliente)
    {
        // Verifica se a conexão existe no config/database.php
        if (! Config::has('database.connections.previnir')) {
            return;
        }

        try {
            // Testa a conexão
            DB::connection('previnir')->getPdo();
        } catch (\Throwable $e) {
            // Não conseguiu conectar
            return;
        }

        // Daqui para frente a conexão existe e está acessível
        $principal_cliente = Cliente::where('id', $cliente->principal_cliente_id)->value('name');
        $identidade_estado = Estado::where('id', $cliente->identidade_estado_id)->value('name');
        $identidade_orgao = IdentidadeOrgao::where('id', $cliente->identidade_orgao_id)->value('name');
        $genero = Genero::where('id', $cliente->genero_id)->value('name');
        $banco = Banco::where('id', $cliente->banco_id)->value('name');
        $rede_cliente = Cliente::where('id', $cliente->rede_cliente_id)->value('name');

        DB::connection('previnir')
            ->table('gsr_clientes')
            ->updateOrInsert(
                ['id' => $cliente->id],
                [
                    'principal_cliente_id' => $cliente->principal_cliente_id,
                    'identidade_estado_id' => $cliente->identidade_estado_id,
                    'identidade_orgao_id' => $cliente->identidade_orgao_id,
                    'genero_id' => $cliente->genero_id,
                    'banco_id' => $cliente->banco_id,
                    'rede_cliente_id' => $cliente->rede_cliente_id,

                    'principal_cliente' => $principal_cliente,
                    'identidade_estado' => $identidade_estado,
                    'identidade_orgao' => $identidade_orgao,
                    'genero' => $genero,
                    'banco' => $banco,
                    'rede_cliente' => $rede_cliente,

                    'status' => $cliente->status,
                    'tipo' => $cliente->tipo,
                    'name' => $cliente->name,
                    'nome_fantasia' => $cliente->nome_fantasia,
                    'inscricao_estadual' => $cliente->inscricao_estadual,
                    'inscricao_municipal' => $cliente->inscricao_municipal,
                    'cpf' => $cliente->cpf,
                    'cnpj' => $cliente->cnpj,
                    'identidade_numero' => $cliente->identidade_numero,
                    'identidade_data_emissao' => $cliente->identidade_data_emissao,
                    'data_nascimento' => $cliente->data_nascimento,
                    'cep' => $cliente->cep,
                    'numero' => $cliente->numero,
                    'complemento' => $cliente->complemento,
                    'logradouro' => $cliente->logradouro,
                    'bairro' => $cliente->bairro,
                    'localidade' => $cliente->localidade,
                    'uf' => $cliente->uf,
                    'cep_cobranca' => $cliente->cep_cobranca,
                    'numero_cobranca' => $cliente->numero_cobranca,
                    'complemento_cobranca' => $cliente->complemento_cobranca,
                    'logradouro_cobranca' => $cliente->logradouro_cobranca,
                    'bairro_cobranca' => $cliente->bairro_cobranca,
                    'localidade_cobranca' => $cliente->localidade_cobranca,
                    'uf_cobranca' => $cliente->uf_cobranca,
                    'agencia' => $cliente->agencia,
                    'conta' => $cliente->conta,
                    'email' => $cliente->email,
                    'site' => $cliente->site,
                    'telefone_1' => $cliente->telefone_1,
                    'telefone_2' => $cliente->telefone_2,
                    'celular_1' => $cliente->celular_1,
                    'celular_2' => $cliente->celular_2,
                    'logotipo_principal' => $cliente->logotipo_principal,
                    'logotipo_relatorios' => $cliente->logotipo_relatorios,
                    'logotipo_cartao_emergencial' => $cliente->logotipo_cartao_emergencial,
                    'contato_1_nome' => $cliente->contato_1_nome,
                    'contato_1_setor' => $cliente->contato_1_setor,
                    'contato_1_cargo' => $cliente->contato_1_cargo,
                    'contato_1_email' => $cliente->contato_1_email,
                    'contato_2_nome' => $cliente->contato_2_nome,
                    'contato_2_setor' => $cliente->contato_2_setor,
                    'contato_2_cargo' => $cliente->contato_2_cargo,
                    'contato_2_email' => $cliente->contato_2_email,
                    'dominio' => $cliente->dominio,
                    'logotipo_menu' => $cliente->logotipo_menu,
                    'email_avisos' => $cliente->email_avisos,
                    'created_at' => $cliente->created_at,
                    'updated_at' => $cliente->updated_at
                ]
            );
    }
}
