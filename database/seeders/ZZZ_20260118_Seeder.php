<?php

namespace Database\Seeders;

use App\Models\Documento;
use App\Models\DocumentoFonte;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\Modulo;
use App\Models\Permissao;
use App\Models\Submodulo;
use App\Models\VisitaTecnicaPergunta;
use Illuminate\Database\Seeder;

class ZZZ_20260118_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Documento Fontes e Documentos'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Documento Fontes
        DocumentoFonte::create(['id' => 6, 'name' => 'ANOTAÇÕES DE RESPONSABILIDADE TÉCNICA (ARTS OBRIGATÓRIAS)  - INSTALAÇÃO, INSPEÇÃO, TESTES E MANUTENÇÃO', 'ordem' => 60]);
        DocumentoFonte::create(['id' => 7, 'name' => 'ANOTAÇÕES DE RESPONSABILIDADE TÉCNICA (ARTS OBRIGATÓRIAS)  - SISTEMAS ELÉTRICOS, ENERGÉTICOS E COMPLEMENTARES', 'ordem' => 70]);

        // Documentos
        Documento::create(['id' => 65, 'name' => 'ART do sistema da rede de hidrantes da rede de hidrantes e mangotinhos (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 240]);
        Documento::create(['id' => 66, 'name' => 'ART do sistema de bombas de incêndio (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 250]);
        Documento::create(['id' => 67, 'name' => 'ART do sistema de sprinklers (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 260]);
        Documento::create(['id' => 68, 'name' => 'ART do sistema de detecção e alarme de incêndio (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 270]);
        Documento::create(['id' => 69, 'name' => 'ART do sistema de iluminação de emergência (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 280]);
        Documento::create(['id' => 70, 'name' => 'ART do Sistema de Proteção contra Descargas Atmosféricas (SPDA) (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 290]);
        Documento::create(['id' => 71, 'name' => 'ART do sistema de controle de fumaça e calor, quando existente', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 300]);
        Documento::create(['id' => 72, 'name' => 'ART do sistema de pressurização de escadas, quando aplicável', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 310]);
        Documento::create(['id' => 73, 'name' => 'ART do sistema de gás (GLP ou GN), incluindo estanqueidade e segurança (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 320]);
        Documento::create(['id' => 74, 'name' => 'ART e nota fiscal de inspeção e manutenção de extintores de incêndio', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 330]);
        Documento::create(['id' => 75, 'name' => 'Contrato de prestação de serviços da Brigada de Incêndio, quando aplicável', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 340]);
        Documento::create(['id' => 76, 'name' => 'ART de responsável técnico pela edificação, quando aplicável', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 6, 'ordem' => 350]);
        Documento::create(['id' => 77, 'name' => 'ART do sistema elétrico da edificação (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 360]);
        Documento::create(['id' => 78, 'name' => 'ART dos quadros elétricos e painéis de distribuição (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 370]);
        Documento::create(['id' => 79, 'name' => 'ART dos sistemas elétricos de segurança (alimentação dos sistemas de incêndio)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 380]);
        Documento::create(['id' => 80, 'name' => 'ART do grupo gerador de energia (inspeção, testes, manutenção e comissionamento)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 390]);
        Documento::create(['id' => 81, 'name' => 'ART do sistema de transferência automática (QTA/ATS)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 400]);
        Documento::create(['id' => 82, 'name' => 'ART da central de gás (GLP ou GN), incluindo projeto', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 410]);
        Documento::create(['id' => 83, 'name' => 'ART de teste de estanqueidade da rede de gás (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 420]);
        Documento::create(['id' => 84, 'name' => 'ART dos sistemas de ventilação permanente e exaustão da central de gás (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 430]);
        Documento::create(['id' => 85, 'name' => 'ART de sistemas de aterramento elétrico e equipotencialização (inspeção, testes e manutenção)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 440]);
        Documento::create(['id' => 86, 'name' => 'ART de sistemas especiais integrados à segurança (CFTV, controle de acesso, quando vinculados a rotas de fuga ou segurança operacional)', 'documento_submodulo_id' => 1, 'documento_fonte_id' => 7, 'ordem' => 450]);
        //'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Visita Técnica Perguntas (INCÊNDIO) - Deletar/Criar'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Deletar
        VisitaTecnicaPergunta::whereIn('id', [115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150, 151, 152, 153, 154, 155, 156, 157])->delete();

        // Criar
        $ordem = 0;

        $titulo = "DOCUMENTAÇÃO LEGAL - COSCIP";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "PSCIP aprovado e compatível com a situação atual da edificação - Médio";
        VisitaTecnicaPergunta::create(['id' => 115, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Existência de Laudo de Exigências emitido pelo CBMERJ - Médio";
        VisitaTecnicaPergunta::create(['id' => 116, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Certificado de Aprovação (CA / AVCB) vigente e compatível com o uso real - 🔴 Crítico";
        VisitaTecnicaPergunta::create(['id' => 117, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "ARTs vigentes dos sistemas preventivos - Médio";
        VisitaTecnicaPergunta::create(['id' => 118, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Plano de manutenção implementado conforme COSCIP e NTs - Médio";
        VisitaTecnicaPergunta::create(['id' => 119, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Registros de manutenção mensais atualizados - Médio";
        VisitaTecnicaPergunta::create(['id' => 120, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Relatórios de não conformidades anteriores tratados e encerrados - Baixo";
        VisitaTecnicaPergunta::create(['id' => 121, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Rotina formal de inspeções mensais implementada - Médio";
        VisitaTecnicaPergunta::create(['id' => 122, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Evidência de treinamento/orientação interna - Baixo";
        VisitaTecnicaPergunta::create(['id' => 123, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Plantas e documentos “as built” disponíveis - Baixo";
        VisitaTecnicaPergunta::create(['id' => 124, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Contatos de emergência atualizados e afixados - Médio";
        VisitaTecnicaPergunta::create(['id' => 125, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Registro de simulados/exercícios de abandono - Médio";
        VisitaTecnicaPergunta::create(['id' => 126, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "CASA DE MÁQUINAS DE INCÊNDIO (Bombas) - (NT específica + COSCIP)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Conformidade documental específica do sistema";
        VisitaTecnicaPergunta::create(['id' => 127, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sistema de bombas contemplado no PSCIP aprovado e compatível com a situação atual da edificação - Médio";
        VisitaTecnicaPergunta::create(['id' => 128, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Existência de Laudo de Exigências do CBMERJ relacionado ao sistema de bombas (quando aplicável, decorrente de vistoria ou análise técnica) - Médio";
        VisitaTecnicaPergunta::create(['id' => 129, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Atendimento integral às exigências relacionadas ao sistema de bombas constantes em Laudo de Exigências (quando existente) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 130, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "Ambiente e acesso";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Casa de máquinas exclusiva e identificada - Médio";
        VisitaTecnicaPergunta::create(['id' => 131, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Acesso permanente desobstruído e sinalizado - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 132, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Iluminação (normal e emergência) funcionando - Médio";
        VisitaTecnicaPergunta::create(['id' => 133, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Ventilação adequada e ausência de superaquecimento - Médio";
        VisitaTecnicaPergunta::create(['id' => 134, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Piso seco, sem infiltrações/alagamento/risco elétrico - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 135, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sinalização de “Casa de Máquinas/Bomba de Incêndio” visível na entrada - Baixo";
        VisitaTecnicaPergunta::create(['id' => 136, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Porta/fechamento garantindo controle de acesso e preservação do sistema - Médio";
        VisitaTecnicaPergunta::create(['id' => 137, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Ausência de armazenamento indevido na sala (materiais, lixo, inflamáveis) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 138, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sinalização de risco elétrico e orientação operacional afixada - Baixo";
        VisitaTecnicaPergunta::create(['id' => 139, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "Conjunto de bombas";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Bomba principal existente e compatível com o projeto - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 140, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Bomba jockey instalada e funcional - Médio";
        VisitaTecnicaPergunta::create(['id' => 141, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Bomba reserva instalada (quando exigida) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 142, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Bombas firmemente fixadas, alinhadas, sem vibração anormal - Médio";
        VisitaTecnicaPergunta::create(['id' => 143, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Ausência de ruído anormal no funcionamento (quando testado) - Médio";
        VisitaTecnicaPergunta::create(['id' => 144, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Identificação/placa do conjunto (principal/jockey/reserva) legível - Baixo";
        VisitaTecnicaPergunta::create(['id' => 145, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "Montagem hidráulica - sucção / recalque";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Linha de sucção exclusiva e adequada (sem estrangulamentos) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 146, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvula de bloqueio na sucção operante - Médio";
        VisitaTecnicaPergunta::create(['id' => 147, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvula de retenção no recalque instalada e operante - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 148, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvula de bloqueio no recalque operante - Médio";
        VisitaTecnicaPergunta::create(['id' => 149, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Ausência de vazamentos/oxidação crítica - Médio";
        VisitaTecnicaPergunta::create(['id' => 150, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Tubulações identificadas (sucção/recalque) e sentido de fluxo visível - Baixo";
        VisitaTecnicaPergunta::create(['id' => 151, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvulas com indicação clara de aberto/fechado e travamento quando aplicável - Médio";
        VisitaTecnicaPergunta::create(['id' => 152, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "Manômetros e instrumentação";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Manômetro na sucção instalado e legível - Médio";
        VisitaTecnicaPergunta::create(['id' => 153, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Manômetro no recalque instalado e legível - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 154, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Escala adequada e ponteiro sem travamento - Médio";
        VisitaTecnicaPergunta::create(['id' => 155, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Registros/engates para teste de pressão/vazão disponíveis - Médio";
        VisitaTecnicaPergunta::create(['id' => 156, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "Painel de comando e elétrica";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Painel exclusivo e identificado “BOMBA DE INCÊNDIO” - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 157, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Modo automático habilitado e funcional - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 158, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Modo manual funcional - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 159, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sinalizações (rede ok / falha / bomba ligada) - Médio";
        VisitaTecnicaPergunta::create(['id' => 160, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Proteções não permitem desligamento indevido em emergência - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 161, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Alimentação elétrica dedicada/segura (e gerador quando exigido) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 162, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Painel com integridade física (sem superaquecimento, sem partes expostas) - Médio";
        VisitaTecnicaPergunta::create(['id' => 163, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Procedimento simples de operação (liga/desliga/teste) afixado - Baixo";
        VisitaTecnicaPergunta::create(['id' => 164, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "Testes mensais (obrigatório no procedimento)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Teste de partida automática realizado e registrado - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 165, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Teste manual realizado e registrado - Médio";
        VisitaTecnicaPergunta::create(['id' => 166, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Resultado de pressão/vazão dentro do aceitável do sistema - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 167, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "RESERVA TÉCNICA DE INCÊNDIO (RTI) / RESERVATÓRIO";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Volume compatível com o sistema/ocupação/projeto - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 168, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Identificação “RESERVA TÉCNICA DE INCÊNDIO” - Médio";
        VisitaTecnicaPergunta::create(['id' => 169, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvulas/registros operantes e lacres quando aplicável - Médio";
        VisitaTecnicaPergunta::create(['id' => 170, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Nível de água garantido (controle/boia/indicador) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 171, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Acesso e condições de inspeção/higienização - Médio";
        VisitaTecnicaPergunta::create(['id' => 172, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Reserva técnica exclusiva (sem consumo indevido/derivações não autorizadas) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 173, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Indicador/boia protegido contra travamento e intervenções indevidas - Médio";
        VisitaTecnicaPergunta::create(['id' => 174, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "SISTEMA DE HIDRANTES E MANGOTINHOS";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Abrangência/alcance conforme projeto - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 175, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Abrigos identificados e desobstruídos - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 176, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Mangueiras dentro da validade/condição física - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 177, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Esguichos e chaves disponíveis - Médio";
        VisitaTecnicaPergunta::create(['id' => 178, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Registro de recalque (bombeiros) sinalizado e acessível - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 179, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Teste mensal de pressurização/funcionamento registrado - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 180, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Abrigos em bom estado (portas/dobradiças/vidros), sem violação - Médio";
        VisitaTecnicaPergunta::create(['id' => 181, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Mangueiras corretamente acondicionadas (dobragem/organização), sem dobras críticas - Médio";
        VisitaTecnicaPergunta::create(['id' => 182, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "SPRINKLERS (Chuveiros Automáticos) - quando aplicável";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Sistema instalado conforme projeto/ocupação - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 183, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvulas de governo identificadas e acessíveis - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 184, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Manômetros da válvula de governo legíveis - Médio";
        VisitaTecnicaPergunta::create(['id' => 185, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sem obstruções nos bicos (distância/forro/armazenagem) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 186, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Bicos sem pintura/danos/corrosão crítica - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 187, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Testes e inspeções mensais registrados - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 188, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvulas de governo na posição correta (abertas) e supervisionadas quando aplicável - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 189, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "DETECÇÃO E ALARME DE INCÊNDIO";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Central de alarme operante (sem falhas permanentes) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 190, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Baterias/backup em condição - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 191, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Acionadores manuais acessíveis e sinalizados - Médio";
        VisitaTecnicaPergunta::create(['id' => 192, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sinalização audiovisual audível/visível - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 193, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Detectores íntegros, limpos e posicionados corretamente - Médio";
        VisitaTecnicaPergunta::create(['id' => 194, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Teste mensal (pelo menos por amostragem) registrado - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 195, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Identificação da central/zonas atualizada conforme layout real - Médio";
        VisitaTecnicaPergunta::create(['id' => 196, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "ILUMINAÇÃO DE EMERGÊNCIA";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Acionamento na falta de energia - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 197, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Cobertura de rotas de fuga/escadas - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 198, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Autonomia compatível (teste) - Médio";
        VisitaTecnicaPergunta::create(['id' => 199, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Luminárias íntegras e bem fixadas - Baixo";
        VisitaTecnicaPergunta::create(['id' => 200, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "SINALIZAÇÃO DE EMERGÊNCIA";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Rotas e saídas identificadas e visíveis - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 201, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Extintores/hidrantes/alarme sinalizados - Médio";
        VisitaTecnicaPergunta::create(['id' => 202, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Conservação/limpeza/sem encobrimento - Baixo";
        VisitaTecnicaPergunta::create(['id' => 203, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "EXTINTORES";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Distribuição e tipo compatíveis com risco - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 204, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Manutenção/validade e lacre ok - Médio";
        VisitaTecnicaPergunta::create(['id' => 205, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Acesso desobstruído e sinalização - Médio";
        VisitaTecnicaPergunta::create(['id' => 206, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Extintores instalados na altura/condição de fixação adequada (suporte íntegro) - Baixo";
        VisitaTecnicaPergunta::create(['id' => 207, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "CONTROLE DE FUMAÇA / PRESSURIZAÇÃO / EXAUSTÃO (quando aplicável)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Sistema operante e integrado ao incêndio - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 208, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Dutos/dampers corta-fogo quando exigido - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 209, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Comandos locais e automáticos funcionais - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 210, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Registros de manutenção/testes - Médio";
        VisitaTecnicaPergunta::create(['id' => 211, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Condição dos ventiladores/motores (fixação, ruído anormal, integridade) - Médio";
        VisitaTecnicaPergunta::create(['id' => 212, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "GLP / GÁS COMBUSTÍVEL (quando aplicável)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Central instalada em local conforme, ventilado e sinalizado - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 213, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Reguladores/mangueiras em conformidade e dentro do prazo - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 214, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Válvula de bloqueio/solenóide e acionamento de emergência - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 215, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Detecção (quando aplicável) e procedimentos operacionais - Médio";
        VisitaTecnicaPergunta::create(['id' => 216, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Sinalização “proibido fumar/chamas” e orientação de emergência visível - Médio";
        VisitaTecnicaPergunta::create(['id' => 217, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "SPDA (quando aplicável)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Integridade visível (captores/descidas/conexões) - Médio";
        VisitaTecnicaPergunta::create(['id' => 218, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Laudo/medição e manutenção periódica - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 219, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Aterramentos/pontos acessíveis protegidos contra corrosão evidente - Médio";
        VisitaTecnicaPergunta::create(['id' => 220, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "ORGANIZAÇÃO OPERACIONAL (BRIGADA / BPC / PLANO)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Brigada dimensionada e escalada - Médio";
        VisitaTecnicaPergunta::create(['id' => 221, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Treinamentos e simulados registrados - Médio";
        VisitaTecnicaPergunta::create(['id' => 222, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "BPC presente quando exigido - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 223, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Plano de emergência atualizado e divulgado - Médio";
        VisitaTecnicaPergunta::create(['id' => 224, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Procedimento de abandono e pontos de encontro divulgados - Médio";
        VisitaTecnicaPergunta::create(['id' => 225, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Equipamentos básicos de apoio (lanterna, rádio, chaves de acesso) quando aplicável - Baixo";
        VisitaTecnicaPergunta::create(['id' => 226, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);





        $titulo = "SAÍDAS DE EMERGÊNCIA / ROTAS DE FUGA (COMPLEMENTAR - VISTORIA DE CAMPO)";
        $subtitulo = "";

        $ordem += 50;
        $pergunta = "Rotas de fuga contínuas e desobstruídas (sem barreiras/fechamentos) - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 227, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Portas de emergência abrem no sentido da fuga e sem travamento indevido - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 228, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Escadas protegidas/enclausuradas quando exigido - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 229, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Corrimãos/guarda-corpos/patamares em conformidade - Médio";
        VisitaTecnicaPergunta::create(['id' => 230, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);

        $ordem += 50;
        $pergunta = "Portas corta-fogo (quando existentes) íntegras e com fechamento automático - Crítico 🔴";
        VisitaTecnicaPergunta::create(['id' => 231, 'visita_tecnica_tipo_id' => 2, 'titulo' => $titulo, 'subtitulo' => $subtitulo, 'pergunta' => $pergunta, 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Mobile'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // mobile=0
        Modulo::query()->update(['mobile' => 0]);
        Submodulo::query()->update(['mobile' => 0]);

        // Modulo=6 : Recursos Humanos
        Modulo::where('id', 6)->update(['mobile' => 1]);
        Submodulo::where('id', 14)->update(['mobile' => 1]); // Funcionários

        // Modulo=7 : Relacionamento
        Modulo::where('id', 7)->update(['mobile' => 1]);
        Submodulo::where('id', 16)->update(['mobile' => 1]); // Clientes

        // Modulo=8 : Operações
        Modulo::where('id', 8)->update(['mobile' => 1]);
        Submodulo::where('id', 22)->update(['mobile' => 1]); // Visitas Técnicas
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Domínio Clientes'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        // Grupo
        Grupo::create(['id' => 11, 'name' => 'DOMÍNIO CLIENTES']);

        // Dados 1 - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 41, 'modulo_id' => 1, 'name' => 'Clientes Dashboards', 'menu_text' => 'Dashboards', 'menu_url' => 'clientes_dashboards', 'menu_route' => 'clientes_dashboards', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes_dashboards', 'prefix_route' => 'clientes_dashboards', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 10]);

        // Permissões
        Permissao::create(['id' => 197, 'submodulo_id' => 41, 'name' => 'clientes_dashboards_list', 'description' => '']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 197]);
        // Dados 1 - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Dados 2 - Início'''''''''''''''''''''''''''''''''''''''''''''''''''''''

        // Submódulo
        Submodulo::create(['id' => 42, 'modulo_id' => 6, 'name' => 'Clientes Funcionários', 'menu_text' => 'Funcionários', 'menu_url' => 'clientes_funcionarios', 'menu_route' => 'clientes_funcionarios', 'menu_icon' => 'fas fa-angle-right', 'prefix_permissao' => 'clientes_funcionarios', 'prefix_route' => 'clientes_funcionarios', 'mobile' => 0, 'menu_text_mobile' => '', 'viewing_order' => 10]);

        // Permissões
        Permissao::create(['id' => 198, 'submodulo_id' => 42, 'name' => 'clientes_funcionarios_list', 'description' => '']);
        Permissao::create(['id' => 199, 'submodulo_id' => 42, 'name' => 'clientes_funcionarios_show', 'description' => '']);

        // Grupo Permissão
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 198]);
        GrupoPermissao::create(['grupo_id' => 11, 'permissao_id' => 199]);
        // Dados 2 - FIM''''''''''''''''''''''''''''''''''''''''''''''''''''''''''

        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
