<?php

namespace Database\Seeders;

use App\Models\ClienteExecutivo;
use App\Models\Departamento;
use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\DocumentoSubmodulo;
use App\Models\Funcao;
use App\Models\Funcionario;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Modulo;
use App\Models\Permissao;
use App\Models\Relatorio;
use App\Models\Submodulo;
use Illuminate\Database\Seeder;

class ZZZ_20250706_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Deletando tudo relacionado a Notificações e Ferramentas'''''''''''''''''''''''''''''''''''''''''''''''''''''''
        GrupoRelatorio::where('relatorio_id', 4)->delete();
        GrupoRelatorio::where('relatorio_id', 5)->delete();

        Relatorio::where('id', 4)->delete();
        Relatorio::where('id', 5)->delete();

        GrupoPermissao::where('permissao_id', 11)->delete();
        GrupoPermissao::where('permissao_id', 12)->delete();
        GrupoPermissao::where('permissao_id', 13)->delete();
        GrupoPermissao::where('permissao_id', 14)->delete();
        GrupoPermissao::where('permissao_id', 15)->delete();
        GrupoPermissao::where('permissao_id', 21)->delete();
        GrupoPermissao::where('permissao_id', 22)->delete();
        GrupoPermissao::where('permissao_id', 23)->delete();
        GrupoPermissao::where('permissao_id', 24)->delete();
        GrupoPermissao::where('permissao_id', 25)->delete();

        Permissao::where('id', 11)->delete();
        Permissao::where('id', 12)->delete();
        Permissao::where('id', 13)->delete();
        Permissao::where('id', 14)->delete();
        Permissao::where('id', 15)->delete();
        Permissao::where('id', 21)->delete();
        Permissao::where('id', 22)->delete();
        Permissao::where('id', 23)->delete();
        Permissao::where('id', 24)->delete();
        Permissao::where('id', 25)->delete();

        Submodulo::where('id', 3)->delete();
        Submodulo::where('id', 5)->delete();

        Modulo::where('id', 2)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Mudanças nos Departamentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Atualiza funcionários que estão no departamento 6 para o departamento 3
        Funcionario::where('departamento_id', 6)->update(['departamento_id' => 3]);

        // Remove o departamento com ID 6, se existir
        Departamento::where('id', 6)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer funcionarios para gravar campo nome_profissional com primeiro e último nome do campo name''''''''''''''
        $funcionarios = Funcionario::all();

        foreach ($funcionarios as $funcionario) {
            $partes = preg_split('/\s+/', trim($funcionario->name));

            if (count($partes) >= 2) {
                $nomeProfissional = $partes[0] . ' ' . end($partes);
            } else {
                $nomeProfissional = $funcionario->name;
            }

            $funcionario->nome_profissional = $nomeProfissional;
            $funcionario->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer clientes_executivos para gravar campo nome_profissional com primeiro e último nome do campo executivo_nome
        $clientes_executivos = ClienteExecutivo::all();

        foreach ($clientes_executivos as $clientes_executivo) {
            $partes = preg_split('/\s+/', trim($clientes_executivo->executivo_nome));

            if (count($partes) >= 2) {
                $nomeProfissional = $partes[0] . ' ' . end($partes);
            } else {
                $nomeProfissional = $clientes_executivo->executivo_nome;
            }

            $clientes_executivo->nome_profissional = $nomeProfissional;
            $clientes_executivo->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
