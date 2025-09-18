<?php

namespace Database\Seeders;

use App\Models\AtestadoSaudeOcupacionalTipo;
use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\EscalaTipo;
use App\Models\Funcionario;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\GrupoRelatorio;
use App\Models\Material;
use App\Models\MaterialCategoria;
use App\Models\Modulo;
use App\Models\MotivoAfastamento;
use App\Models\MotivoDemissao;
use App\Models\Permissao;
use App\Models\Submodulo;
use App\Models\User;
use App\Models\VisitaTecnicaPergunta;
use Illuminate\Database\Seeder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ZZZ_20250721_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        //Varrer users para gravar campos de configurações''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $users = User::all();

        foreach ($users as $user) {
            $grupo_id = 3;
            $situacao_id = 1;
            $layout_mode = 'layout_mode_light';
            $layout_style = 'layout_style_vertical_scrollable';

            if ($user->id == 1 or $user->id == 2) {$grupo_id = 1;}

            $user->grupo_id = $grupo_id;
            $user->situacao_id = $situacao_id;
            $user->layout_mode = $layout_mode;
            $user->layout_style = $layout_style;

            $user->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer grupos para deletar registros nas tabelas grupos_permissoes, grupos_relatorios e grupos''''''''''''''''
        $grupos = Grupo::all();

        foreach ($grupos as $grupo) {
            if ($grupo->empresa_id == 2 or $grupo->empresa_id == 3) {
                GrupoPermissao::where('grupo_id', $grupo->id)->delete();
                GrupoRelatorio::where('grupo_id', $grupo->id)->delete();

                $grupo->delete();
            }
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Deletar campo empresa_id da tabela grupos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropForeign(['empresa_id']);
            $table->dropColumn('empresa_id');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Motivos Demissoes'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        MotivoDemissao::create(['id' => 1, 'name' => 'Demissão sem justa causa']);
        MotivoDemissao::create(['id' => 2, 'name' => 'Pedido de demissão']);
        MotivoDemissao::create(['id' => 3, 'name' => 'Demissão por justa causa']);
        MotivoDemissao::create(['id' => 4, 'name' => 'Rescisão indireta']);
        MotivoDemissao::create(['id' => 5, 'name' => 'Acordo entre as partes']);
        MotivoDemissao::create(['id' => 6, 'name' => 'Término de contrato por prazo determinado']);
        MotivoDemissao::create(['id' => 7, 'name' => 'Morte do empregado']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Motivos Afastamentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        MotivoAfastamento::create(['id' => 1, 'name' => 'Término de contrato de prestação de serviço']);
        MotivoAfastamento::create(['id' => 2, 'name' => 'Término de contrato de estágio']);
        MotivoAfastamento::create(['id' => 3, 'name' => 'Desligamento por decisão da empresa']);
        MotivoAfastamento::create(['id' => 4, 'name' => 'Desligamento por decisão do colaborador']);
        MotivoAfastamento::create(['id' => 5, 'name' => 'Desligamento por mútuo acordo']);
        MotivoAfastamento::create(['id' => 6, 'name' => 'Encerramento do projeto']);
        MotivoAfastamento::create(['id' => 7, 'name' => 'Falta de desempenho ou adequação']);
        MotivoAfastamento::create(['id' => 8, 'name' => 'Problemas disciplinares']);
        MotivoAfastamento::create(['id' => 9, 'name' => 'Falta de demanda ou orçamento']);
        MotivoAfastamento::create(['id' => 10, 'name' => 'Motivos de saúde']);
        MotivoAfastamento::create(['id' => 11, 'name' => 'Morte do colaborador']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Documentos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Documento Fontes
        DocumentoFonte::create(['id' => 4, 'name' => 'DOCUMENTOS PESSOAIS', 'ordem' => 40]);
        DocumentoFonte::create(['id' => 5, 'name' => 'DOCUMENTOS PROFISSIONAIS', 'ordem' => 50]);

        //Alterando Dados
        DB::table('documentos')->where('id', 14)->update(['name' => 'Identidade', 'documento_fonte_id' => 4, 'ordem' => 10]);
        DB::table('documentos')->where('id', 15)->update(['name' => 'CPF', 'documento_fonte_id' => 4, 'ordem' => 20]);
        DB::table('documentos')->where('id', 16)->update(['name' => 'CNH', 'documento_fonte_id' => 4, 'ordem' => 30]);
        DB::table('documentos')->where('id', 17)->update(['name' => 'CTPS', 'documento_fonte_id' => 4, 'ordem' => 40]);
        DB::table('documentos')->where('id', 18)->update(['name' => 'Chave PIX', 'documento_fonte_id' => 4, 'ordem' => 50]);

        //Incluindo Dados
        Documento::create(['id' => 24, 'name' => 'Comprovante de residência', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 60]);
        Documento::create(['id' => 25, 'name' => 'Histórico escolar', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 70]);
        Documento::create(['id' => 26, 'name' => 'Certidão de nascimento', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 80]);
        Documento::create(['id' => 27, 'name' => 'Certidão de casamento', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 90]);
        Documento::create(['id' => 28, 'name' => 'Título de eleitor', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 100]);
        Documento::create(['id' => 29, 'name' => 'Certificado de Reservista', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 110]);
        Documento::create(['id' => 30, 'name' => 'Antecedentes criminais', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 120]);
        Documento::create(['id' => 31, 'name' => 'Dados Bancários', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 130]);
        Documento::create(['id' => 32, 'name' => 'Dependentes', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 4, 'ordem' => 140]);
        Documento::create(['id' => 33, 'name' => 'Certificado de Bombeiro Civil', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 150]);
        Documento::create(['id' => 34, 'name' => 'Reciclagem de Bombeiro Civil', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 160]);
        Documento::create(['id' => 35, 'name' => 'Homologação', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 170]);
        Documento::create(['id' => 36, 'name' => 'NR 06', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 180]);
        Documento::create(['id' => 37, 'name' => 'NR 10', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 190]);
        Documento::create(['id' => 38, 'name' => 'NR 33', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 200]);
        Documento::create(['id' => 39, 'name' => 'NR 20', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 210]);
        Documento::create(['id' => 40, 'name' => 'NR 35', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 220]);
        Documento::create(['id' => 41, 'name' => 'Atestado de Saúde Ocupacional', 'documento_submodulo_id' => 2, 'documento_fonte_id' => 5, 'ordem' => 230]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Visita Técnica Perguntas - Criar''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        VisitaTecnicaPergunta::create(['id' => 97, 'visita_tecnica_tipo_id' => 1, 'ordem' => 401, 'titulo' => 'REQUISITOS GERAIS', 'subtitulo' => '', 'pergunta' => 'DISPOSITIVOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO ?']);
        VisitaTecnicaPergunta::create(['id' => 98, 'visita_tecnica_tipo_id' => 1, 'ordem' => 402, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'TODOS OS ELEMENTOS DO SISTEMA (COIFAS, DUTOS, VENTILADORES) SÃO CONSTRUÍDOS COM MATERIAIS NÃO COMBUSTÍVEIS?']);
        VisitaTecnicaPergunta::create(['id' => 99, 'visita_tecnica_tipo_id' => 1, 'ordem' => 403, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'INSTALAÇÃO POSSUI ISOLAMENTO TÉRMICO ADEQUADO ONDE HÁ PROXIMIDADE COM ESTRUTURAS COMBUSTÍVEIS?']);
        VisitaTecnicaPergunta::create(['id' => 100, 'visita_tecnica_tipo_id' => 1, 'ordem' => 404, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'RESPEITO AOS DIMENSIONAMENTOS MÍNIMOS DE SEGURANÇA ENTRE DUTOS E MATERIAIS INFLAMÁVEIS?']);
        VisitaTecnicaPergunta::create(['id' => 101, 'visita_tecnica_tipo_id' => 1, 'ordem' => 405, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'SISTEMAS DE EXAUSTÃO POSSUI DAMPER CORTA-FOGO?']);
        VisitaTecnicaPergunta::create(['id' => 102, 'visita_tecnica_tipo_id' => 1, 'ordem' => 406, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'PRESENÇA DE REDE DE CHUVEIROS AUTOMÁTICOS DO TIPO SPRINKLERS?']);
        VisitaTecnicaPergunta::create(['id' => 103, 'visita_tecnica_tipo_id' => 1, 'ordem' => 407, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'SISTEMA DE DETECÇÃO DE FUMAÇA E ALARME DE INCÊNDIO?']);
        VisitaTecnicaPergunta::create(['id' => 104, 'visita_tecnica_tipo_id' => 1, 'ordem' => 408, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'SISTEMA DE CO₂?']);
        VisitaTecnicaPergunta::create(['id' => 105, 'visita_tecnica_tipo_id' => 1, 'ordem' => 409, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'SAPONIFICANTE?']);
        VisitaTecnicaPergunta::create(['id' => 106, 'visita_tecnica_tipo_id' => 1, 'ordem' => 410, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'SISTEMA DE EXAUSTÃO POSSUI DISPOSITIVO DE DESLIGAMENTO AUTOMÁTICO DO GÁS EM CASO DE INCÊNDIO?']);
        VisitaTecnicaPergunta::create(['id' => 107, 'visita_tecnica_tipo_id' => 1, 'ordem' => 411, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'ACESSO AOS EQUIPAMENTOS DE SEGURANÇA CONTRA INCÊNDIO FACILITADO E SINALIZADO?']);
        VisitaTecnicaPergunta::create(['id' => 108, 'visita_tecnica_tipo_id' => 1, 'ordem' => 412, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'INSPEÇÃO E LIMPEZA PERIÓDICA DOS COMPONENTES DO SISTEMA DE EXAUSTÃO (PRINCIPALMENTE FILTROS E DUTOS)?']);
        VisitaTecnicaPergunta::create(['id' => 109, 'visita_tecnica_tipo_id' => 1, 'ordem' => 413, 'titulo' => 'ELEMENTOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'EXISTÊNCIA DE REGISTROS DE PREVENTIVA E CORRETIVA DOS SISTEMAS PREVENTIVOS?']);
        VisitaTecnicaPergunta::create(['id' => 110, 'visita_tecnica_tipo_id' => 1, 'ordem' => 414, 'titulo' => 'REQUISITOS ADICIONAIS PARA COMBUSTÍVEIS SÓLIDOS', 'subtitulo' => '', 'pergunta' => 'SISTEMA DE DETECÇÃO DE FUMAÇA E ALARME DE INCÊNDIO?']);
        VisitaTecnicaPergunta::create(['id' => 111, 'visita_tecnica_tipo_id' => 1, 'ordem' => 415, 'titulo' => 'REQUISITOS ADICIONAIS PARA COMBUSTÍVEIS SÓLIDOS', 'subtitulo' => '', 'pergunta' => 'SISTEMA DE CO₂?']);
        VisitaTecnicaPergunta::create(['id' => 112, 'visita_tecnica_tipo_id' => 1, 'ordem' => 416, 'titulo' => 'REQUISITOS ADICIONAIS PARA COMBUSTÍVEIS SÓLIDOS', 'subtitulo' => '', 'pergunta' => 'SAPONIFICANTE?']);
        VisitaTecnicaPergunta::create(['id' => 113, 'visita_tecnica_tipo_id' => 1, 'ordem' => 417, 'titulo' => 'DOS SISTEMAS OPERACIONAIS', 'subtitulo' => '', 'pergunta' => 'DISPOSITIVOS DE PREVENÇÃO E PROTEÇÃO CONTRA INCÊNDIO ?']);
        VisitaTecnicaPergunta::create(['id' => 114, 'visita_tecnica_tipo_id' => 1, 'ordem' => 418, 'titulo' => 'DOS SISTEMAS OPERACIONAIS', 'subtitulo' => '', 'pergunta' => 'Sistema de CO₂?']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Visita Técnica Perguntas - Alterar''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $ordem = 50;
        VisitaTecnicaPergunta::where('id', 1)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 2)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 3)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 4)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 5)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 6)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 7)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 8)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 9)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 10)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 11)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 12)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 13)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 14)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 15)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 16)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 17)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 18)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 19)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 20)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 21)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 22)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 23)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 24)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 25)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 26)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 27)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 28)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 29)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 30)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 31)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 32)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 33)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 37)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 38)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 39)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 40)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 97)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 98)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 99)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 100)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 101)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 102)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 103)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 104)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 105)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 106)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 107)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 108)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 109)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 110)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 111)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 112)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 113)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 114)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 41)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 42)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 43)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 44)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 45)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 46)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 47)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 48)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 49)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 50)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 51)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 52)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 53)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 54)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 55)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 56)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 57)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 58)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 59)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 60)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 61)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 62)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 63)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 64)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 65)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 66)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 67)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 68)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 69)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 70)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 71)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 72)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 73)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 74)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 75)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 76)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 77)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 78)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 79)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 80)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 81)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 82)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 83)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 84)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 85)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 86)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 87)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 88)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 89)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 90)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 91)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 92)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 93)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 94)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 95)->update(['ordem' => $ordem]);
        $ordem = $ordem + 50;
        VisitaTecnicaPergunta::where('id', 96)->update(['ordem' => $ordem]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Motivos Demissoes'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        AtestadoSaudeOcupacionalTipo::create(['id' => 1, 'name' => 'ADMISSIONAL']);
        AtestadoSaudeOcupacionalTipo::create(['id' => 2, 'name' => 'DEMISSIONAL']);
        AtestadoSaudeOcupacionalTipo::create(['id' => 3, 'name' => 'PERIÓDICO']);
        AtestadoSaudeOcupacionalTipo::create(['id' => 4, 'name' => 'ESPECIAL']);
        AtestadoSaudeOcupacionalTipo::create(['id' => 5, 'name' => 'MUDANÇA DE FUNÇÃO']);
        AtestadoSaudeOcupacionalTipo::create(['id' => 6, 'name' => 'RETORNO AO TRABALHO']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Alterar nomes de Módulos''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Modulo::where('id', 1)->update(['name' => 'Painel Principal', 'menu_text' => 'Painel Principal', 'menu_url' => 'painel_principal', 'menu_route' => 'painel_principal', 'menu_icon' => 'bx bxs-dashboard', 'viewing_order' => 10]);
        Modulo::where('id', 3)->update(['name' => 'Relatórios', 'menu_text' => 'Relatórios', 'menu_url' => 'relatorios', 'menu_route' => 'relatorios', 'menu_icon' => 'bx bxs-printer ', 'viewing_order' => 2000]);
        Modulo::where('id', 4)->update(['name' => 'Auxiliares', 'menu_text' => 'Auxiliares', 'menu_url' => 'auxiliares', 'menu_route' => 'auxiliares', 'menu_icon' => 'bx bxs-food-menu', 'viewing_order' => 1000]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Criar Módulos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Modulo::create(['id' => '5', 'name' => 'Administração', 'menu_text' => 'Administração', 'menu_url' => 'administracao', 'menu_route' => 'administracao', 'menu_icon' => 'bx bxs-business', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 50]);
        Modulo::create(['id' => '6', 'name' => 'Recursos Humanos', 'menu_text' => 'Recursos Humanos', 'menu_url' => 'recursos_humanos', 'menu_route' => 'recursos_humanos', 'menu_icon' => 'bx bxs-user-badge', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 60]);
        Modulo::create(['id' => '7', 'name' => 'Relacionamento', 'menu_text' => 'Relacionamento', 'menu_url' => 'relacionamento', 'menu_route' => 'relacionamento', 'menu_icon' => 'bx bxs-check-square', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 70]);
        Modulo::create(['id' => '8', 'name' => 'Operações', 'menu_text' => 'Operações', 'menu_url' => 'operacoes', 'menu_route' => 'operacoes', 'menu_icon' => 'bx bxs-bank', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 80]);
        Modulo::create(['id' => '9', 'name' => 'Geolocalização', 'menu_text' => 'Geolocalização', 'menu_url' => 'geolocalizacao', 'menu_route' => 'geolocalizacao', 'menu_icon' => 'bx bxs-map-pin', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 90]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Alterar localização do submodulo dentro do modulo'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Submodulo::where('id', 1)->update(['modulo_id' => 5, 'viewing_order' => 10]);
        Submodulo::where('id', 2)->update(['modulo_id' => 5, 'viewing_order' => 20]);
        Submodulo::where('id', 4)->update(['modulo_id' => 5, 'viewing_order' => 30]);
        Submodulo::where('id', 19)->update(['modulo_id' => 5, 'viewing_order' => 0]);
        Submodulo::where('id', 14)->update(['modulo_id' => 6, 'viewing_order' => 10]);
        Submodulo::where('id', 16)->update(['modulo_id' => 7, 'viewing_order' => 10]);
        Submodulo::where('id', 18)->update(['modulo_id' => 7, 'viewing_order' => 20]);
        Submodulo::where('id', 21)->update(['modulo_id' => 8, 'viewing_order' => 10]);
        Submodulo::where('id', 22)->update(['modulo_id' => 8, 'viewing_order' => 20]);
        Submodulo::where('id', 23)->update(['modulo_id' => 8, 'viewing_order' => 30]);
        Submodulo::where('id', 26)->update(['modulo_id' => 8, 'viewing_order' => 40]);
        Submodulo::where('id', 28)->update(['modulo_id' => 7, 'viewing_order' => 20]);
        Submodulo::where('id', 30)->update(['modulo_id' => 9, 'viewing_order' => 10]);
        Submodulo::where('id', 31)->update(['modulo_id' => 9, 'viewing_order' => 20]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer funcionarios para gravar campo fotografia_documento e fotografia_cartao_emergencial igual campo foto'''
        $funcionarios = Funcionario::all();

        foreach ($funcionarios as $funcionario) {
            $foto = $funcionario->foto;

            $funcionario->fotografia_documento = $foto;
            $funcionario->fotografia_cartao_emergencial = $foto;
            $funcionario->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Deletar campo foto da tabela funcionarios'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::table('funcionarios', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Varrer visita_tecnica_perguntas para gravar campo completa_ordem igual a ordem''''''''''''''''''''''''''''''''
        $visita_tecnica_perguntas = VisitaTecnicaPergunta::all();

        foreach ($visita_tecnica_perguntas as $visita_tecnica_pergunta) {
            $ordem = $visita_tecnica_pergunta->ordem;

            $visita_tecnica_pergunta->completa = 1;
            $visita_tecnica_pergunta->completa_ordem = $ordem;

            $visita_tecnica_pergunta->opcoes = 31;

            $visita_tecnica_pergunta->sintetica = 0;
            $visita_tecnica_pergunta->sintetica_ordem = 0;

            $visita_tecnica_pergunta->save();
        }
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Deletar campo ordem da tabela visita_tecnica_perguntas''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Schema::table('visita_tecnica_perguntas', function (Blueprint $table) {
            $table->dropColumn('ordem');
        });
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Alterar campos sintetica e sintetica_ordem''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        VisitaTecnicaPergunta::where('id', 1)->update(['sintetica' => 1, 'sintetica_ordem' => 10]);
        VisitaTecnicaPergunta::where('id', 2)->update(['sintetica' => 1, 'sintetica_ordem' => 20]);
        VisitaTecnicaPergunta::where('id', 3)->update(['sintetica' => 1, 'sintetica_ordem' => 30]);
        VisitaTecnicaPergunta::where('id', 4)->update(['sintetica' => 1, 'sintetica_ordem' => 40]);
        VisitaTecnicaPergunta::where('id', 5)->update(['sintetica' => 1, 'sintetica_ordem' => 50]);
        VisitaTecnicaPergunta::where('id', 6)->update(['sintetica' => 1, 'sintetica_ordem' => 60]);
        VisitaTecnicaPergunta::where('id', 7)->update(['sintetica' => 1, 'sintetica_ordem' => 70]);
        VisitaTecnicaPergunta::where('id', 13)->update(['sintetica' => 1, 'sintetica_ordem' => 80]);
        VisitaTecnicaPergunta::where('id', 18)->update(['sintetica' => 1, 'sintetica_ordem' => 90]);
        VisitaTecnicaPergunta::where('id', 19)->update(['sintetica' => 1, 'sintetica_ordem' => 100]);
        VisitaTecnicaPergunta::where('id', 20)->update(['sintetica' => 1, 'sintetica_ordem' => 110]);
        VisitaTecnicaPergunta::where('id', 22)->update(['sintetica' => 1, 'sintetica_ordem' => 120]);
        VisitaTecnicaPergunta::where('id', 8)->update(['sintetica' => 1, 'sintetica_ordem' => 130]);
        VisitaTecnicaPergunta::where('id', 9)->update(['sintetica' => 1, 'sintetica_ordem' => 140]);
        VisitaTecnicaPergunta::where('id', 70)->update(['sintetica' => 1, 'sintetica_ordem' => 150]);
        VisitaTecnicaPergunta::where('id', 75)->update(['sintetica' => 1, 'sintetica_ordem' => 160]);
        VisitaTecnicaPergunta::where('id', 71)->update(['sintetica' => 1, 'sintetica_ordem' => 170]);
        VisitaTecnicaPergunta::where('id', 72)->update(['sintetica' => 1, 'sintetica_ordem' => 180]);
        VisitaTecnicaPergunta::where('id', 76)->update(['sintetica' => 1, 'sintetica_ordem' => 190]);
        VisitaTecnicaPergunta::where('id', 78)->update(['sintetica' => 1, 'sintetica_ordem' => 200]);
        VisitaTecnicaPergunta::where('id', 82)->update(['sintetica' => 1, 'sintetica_ordem' => 210]);
        VisitaTecnicaPergunta::where('id', 86)->update(['sintetica' => 1, 'sintetica_ordem' => 220]);
        VisitaTecnicaPergunta::where('id', 95)->update(['sintetica' => 1, 'sintetica_ordem' => 230]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Deletando tudo relacionado ao Submódulo Brigadas Incêndios (brigadas)'''''''''''''''''''''''''''''''''''''''''
        GrupoPermissao::where('permissao_id', 111)->delete();
        GrupoPermissao::where('permissao_id', 112)->delete();
        GrupoPermissao::where('permissao_id', 113)->delete();
        GrupoPermissao::where('permissao_id', 114)->delete();
        GrupoPermissao::where('permissao_id', 115)->delete();
        
        Permissao::where('id', 111)->delete();
        Permissao::where('id', 112)->delete();
        Permissao::where('id', 113)->delete();
        Permissao::where('id', 114)->delete();
        Permissao::where('id', 115)->delete();
        
        Submodulo::where('id', 23)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Deletando tudo relacionado ao Submódulo Clientes (Serviços) (clientes_servicos)'''''''''''''''''''''''''''''''
        GrupoPermissao::where('permissao_id', 121)->delete();
        GrupoPermissao::where('permissao_id', 122)->delete();
        GrupoPermissao::where('permissao_id', 123)->delete();
        GrupoPermissao::where('permissao_id', 124)->delete();
        GrupoPermissao::where('permissao_id', 125)->delete();
        
        Permissao::where('id', 121)->delete();
        Permissao::where('id', 122)->delete();
        Permissao::where('id', 123)->delete();
        Permissao::where('id', 124)->delete();
        Permissao::where('id', 125)->delete();
        
        Submodulo::where('id', 25)->delete();
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Material Categorias'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        MaterialCategoria::create(['id' => 1, 'name' => 'Equipamentos de Proteção Individual']);
        MaterialCategoria::create(['id' => 2, 'name' => 'Equipamentos de Combate a Incêndio']);
        MaterialCategoria::create(['id' => 3, 'name' => 'Equipamentos de Detecção e Alarme']);
        MaterialCategoria::create(['id' => 4, 'name' => 'Equipamentos de Primeiros Socorros']);
        MaterialCategoria::create(['id' => 5, 'name' => 'Equipamentos de Resgate']);
        MaterialCategoria::create(['id' => 6, 'name' => 'Comunicação e Sinalização']);
        MaterialCategoria::create(['id' => 7, 'name' => 'Veículos e Sistemas Fixos']);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Materiais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        Material::create(['id' => 1, 'name' => 'Capacete', 'material_categoria_id' => 1]);
        Material::create(['id' => 2, 'name' => 'Luvas', 'material_categoria_id' => 1]);
        Material::create(['id' => 3, 'name' => 'Coturno', 'material_categoria_id' => 1]);
        Material::create(['id' => 4, 'name' => 'Máscara', 'material_categoria_id' => 1]);
        Material::create(['id' => 5, 'name' => 'Óculos', 'material_categoria_id' => 1]);
        Material::create(['id' => 6, 'name' => 'Extintor (PQS)', 'material_categoria_id' => 2]);
        Material::create(['id' => 7, 'name' => 'Extintor (CO₂)', 'material_categoria_id' => 2]);
        Material::create(['id' => 8, 'name' => 'Extintor (água)', 'material_categoria_id' => 2]);
        Material::create(['id' => 9, 'name' => 'Extintor (espuma)', 'material_categoria_id' => 2]);
        Material::create(['id' => 10, 'name' => 'Mangueira', 'material_categoria_id' => 2]);
        Material::create(['id' => 11, 'name' => 'Esguicho', 'material_categoria_id' => 2]);
        Material::create(['id' => 12, 'name' => 'Chave de mangueira', 'material_categoria_id' => 2]);
        Material::create(['id' => 13, 'name' => 'Detectore de fumaça', 'material_categoria_id' => 3]);
        Material::create(['id' => 14, 'name' => 'Detectore de calor', 'material_categoria_id' => 3]);
        Material::create(['id' => 15, 'name' => 'Kit de primeiros socorros', 'material_categoria_id' => 4]);
        Material::create(['id' => 16, 'name' => 'Maca', 'material_categoria_id' => 4]);
        Material::create(['id' => 17, 'name' => 'Colar cervical', 'material_categoria_id' => 4]);
        Material::create(['id' => 18, 'name' => 'Máscara de RCP', 'material_categoria_id' => 4]);
        Material::create(['id' => 19, 'name' => 'Lanterna', 'material_categoria_id' => 5]);
        Material::create(['id' => 20, 'name' => 'Sinalizador', 'material_categoria_id' => 5]);
        Material::create(['id' => 21, 'name' => 'Corda', 'material_categoria_id' => 5]);
        Material::create(['id' => 22, 'name' => 'Mosquetão', 'material_categoria_id' => 5]);
        Material::create(['id' => 23, 'name' => 'Rádio comunicador', 'material_categoria_id' => 6]);
        Material::create(['id' => 24, 'name' => 'Cone', 'material_categoria_id' => 6]);
        Material::create(['id' => 25, 'name' => 'Fita de isolamento', 'material_categoria_id' => 6]);
        Material::create(['id' => 26, 'name' => 'Placa de sinalização', 'material_categoria_id' => 6]);
        Material::create(['id' => 27, 'name' => 'Hidrante', 'material_categoria_id' => 7]);
        Material::create(['id' => 28, 'name' => 'Sprinkler', 'material_categoria_id' => 7]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Submódulo Materiais'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Submódulo
        Submodulo::create(['id' => '32', 'modulo_id' => '4', 'name' => 'Materiais', 'menu_text' => 'Materiais', 'menu_url' => 'materiais', 'menu_route' => 'materiais', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'materiais', 'prefix_route' => 'materiais', 'mobile' => 0, 'menu_text_mobile' => 'Meus Materiais', 'viewing_order' => 120]);

        //Permissões
        Permissao::create(['id' => 152, 'submodulo_id' => 32, 'name' => 'materiais_list', 'description' => 'Visualizar Registro - Materiais']);
        Permissao::create(['id' => 153, 'submodulo_id' => 32, 'name' => 'materiais_create', 'description' => 'Criar Registro - Materiais']);
        Permissao::create(['id' => 154, 'submodulo_id' => 32, 'name' => 'materiais_show', 'description' => 'Visualizar Registro - Materiais']);
        Permissao::create(['id' => 155, 'submodulo_id' => 32, 'name' => 'materiais_edit', 'description' => 'Editar Registro - Materiais']);
        Permissao::create(['id' => 156, 'submodulo_id' => 32, 'name' => 'materiais_destroy', 'description' => 'Deletar Registro - Materiais']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 152]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 153]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 154]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 155]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 156]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Submódulo Brigadas de Incêndios'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        //Submódulo
        Submodulo::create(['id' => '33', 'modulo_id' => '8', 'name' => 'Brigadas Incêndios', 'menu_text' => 'Brigadas Incêndios', 'menu_url' => 'brigadas_incendios', 'menu_route' => 'brigadas_incendios', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'brigadas_incendios', 'prefix_route' => 'brigadas_incendios', 'mobile' => 0, 'menu_text_mobile' => 'Meus Brigadas Incêndios', 'viewing_order' => 40]);

        //Permissões
        Permissao::create(['id' => 157, 'submodulo_id' => 33, 'name' => 'brigadas_incendios_list', 'description' => 'Visualizar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 158, 'submodulo_id' => 33, 'name' => 'brigadas_incendios_create', 'description' => 'Criar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 159, 'submodulo_id' => 33, 'name' => 'brigadas_incendios_show', 'description' => 'Visualizar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 160, 'submodulo_id' => 33, 'name' => 'brigadas_incendios_edit', 'description' => 'Editar Registro - Brigadas Incêndios']);
        Permissao::create(['id' => 161, 'submodulo_id' => 33, 'name' => 'brigadas_incendios_destroy', 'description' => 'Deletar Registro - Brigadas Incêndios']);

        //Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 157]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 158]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 159]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 160]);
        GrupoPermissao::create(['grupo_id' => 1, 'permissao_id' => 161]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //Alterando Dados de ordens de visualização dos submodulos do modulo_id=8'''''''''''''''''''''''''''''''''''''''
        Submodulo::where('id', 21)->update(['viewing_order' => 10]);
        Submodulo::where('id', 26)->update(['viewing_order' => 20]);
        Submodulo::where('id', 22)->update(['viewing_order' => 30]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}