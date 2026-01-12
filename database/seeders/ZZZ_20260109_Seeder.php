<?php

namespace Database\Seeders;

use App\Models\VisitaTecnicaPergunta;
use Illuminate\Database\Seeder;

class ZZZ_20260109_Seeder extends Seeder
{
    /*
     * Sempre que tiver alterações de Seeder depois do dia 15 de março de 2025 fazer um arquivo Z_99999999_Seeder.php
     * Desenvolvimento : colocar no arquivo DatabaseSeeder.php
     * Produção : rodar uma única vez
     */

    public function run()
    {
        // Visita Técnica Perguntas (INCÊNDIO) - Criar''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
        $ordem = 50;
        VisitaTecnicaPergunta::create(['id' => 115, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DOCUMENTAÇÃO LEGAL - COSCIP', 'subtitulo' => '', 'pergunta' => 'PSCIP aprovado e compatível com a ocupação atual ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 116, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DOCUMENTAÇÃO LEGAL - COSCIP', 'subtitulo' => '', 'pergunta' => 'Certificado de Aprovação (AVCB) válido ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 117, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DOCUMENTAÇÃO LEGAL - COSCIP', 'subtitulo' => '', 'pergunta' => 'ARTs dos sistemas preventivos vigentes ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 118, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DOCUMENTAÇÃO LEGAL - COSCIP', 'subtitulo' => '', 'pergunta' => 'Registros de manutenção atualizados ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 119, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Casa de máquinas exclusiva, identificada e sinalizada ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 120, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Acesso permanente, desobstruído e seguro ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 121, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Ambiente protegido contra alagamento, intempéries e uso indevido ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 122, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Iluminação (normal e emergência) adequada ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 123, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Bomba principal instalada e compatível com o projeto aprovado ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 124, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Bomba jockey instalada e funcional ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 125, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Bomba reserva instalada (quando exigido pela NT) ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 126, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Bombas corretamente fixadas, alinhadas e sem vibração excessiva ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 127, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Linha de sucção exclusiva, sem vazamentos ou obstruções ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 128, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Válvula de bloqueio na sucção operante ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 129, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Válvula de retenção instalada no recalque ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 130, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Válvula de bloqueio instalada no recalque ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 131, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Manômetro instalado na sucção e legível ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 132, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Manômetro instalado no recalque e legível ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 133, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Painel de comando exclusivo do sistema de incêndio ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 134, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Modo automático habilitado e funcional ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 135, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Modo manual funcional ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 136, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Painel com sinalização de falha e funcionamento ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 137, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Alimentação elétrica dedicada ao sistema de incêndio ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 138, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Fonte alternativa (gerador), quando exigida ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 139, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Testes mensais automáticos realizados e registrados ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 140, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'CASA DE MÁQUINAS DE INCÊNDIO - BOMBAS', 'subtitulo' => '', 'pergunta' => 'Testes manuais realizados e registrados ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 141, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'SISTEMA DE HIDRANTES E MANGOTINHOS', 'subtitulo' => '', 'pergunta' => 'Abrangência e alcance conforme projeto aprovado ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 142, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'SISTEMA DE HIDRANTES E MANGOTINHOS', 'subtitulo' => '', 'pergunta' => 'Abrigos identificados e desobstruídos ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 143, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'SISTEMA DE HIDRANTES E MANGOTINHOS', 'subtitulo' => '', 'pergunta' => 'Mangueiras dentro do prazo e em bom estado ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 144, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'SISTEMA DE HIDRANTES E MANGOTINHOS', 'subtitulo' => '', 'pergunta' => 'Registros e esguichos operacionais ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 145, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'SISTEMA DE HIDRANTES E MANGOTINHOS', 'subtitulo' => '', 'pergunta' => 'Registro de recalque sinalizado e acessível ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 146, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'SISTEMA DE HIDRANTES E MANGOTINHOS', 'subtitulo' => '', 'pergunta' => 'Teste operacional mensal registrado ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 147, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DETECÇÃO E ALARME DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Central de alarme operante e sem falhas permanentes ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 148, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DETECÇÃO E ALARME DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Baterias e alimentação de emergência em condições ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 149, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DETECÇÃO E ALARME DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Acionadores manuais acessíveis e sinalizados ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 150, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DETECÇÃO E ALARME DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Avisadores sonoros e visuais funcionando ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 151, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'DETECÇÃO E ALARME DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Testes mensais registrados (ao menos por amostragem) ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 152, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'EXTINTORES DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Quantidade e distribuição compatíveis com o risco ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 153, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'EXTINTORES DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Tipos adequados às classes de incêndio ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 154, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'EXTINTORES DE INCÊNDIO', 'subtitulo' => '', 'pergunta' => 'Validade, lacres, sinalização e acesso desobstruído ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 155, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'ILUMINAÇÃO E SINALIZAÇÃO DE EMERGÊNCIA', 'subtitulo' => '', 'pergunta' => 'Iluminação de emergência acionando na falta de energia ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 156, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'ILUMINAÇÃO E SINALIZAÇÃO DE EMERGÊNCIA', 'subtitulo' => '', 'pergunta' => 'Cobertura adequada das rotas de fuga e escadas ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        $ordem += 50;
        VisitaTecnicaPergunta::create(['id' => 157, 'visita_tecnica_tipo_id' => 2, 'titulo' => 'ILUMINAÇÃO E SINALIZAÇÃO DE EMERGÊNCIA', 'subtitulo' => '', 'pergunta' => 'Sinalização fotoluminescente conforme norma ?', 'completa' => 1, 'completa_ordem' => $ordem, 'sintetica' => 1, 'sintetica_ordem' => $ordem, 'opcoes' => 31]);
        //''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    }
}
