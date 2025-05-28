<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\RelatorioExaustao;

class RelatorioExaustaoObserver
{
    public function created(RelatorioExaustao $relatorio_exaustao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'relatorios_exaustoes', $relatorio_exaustao, $relatorio_exaustao);
    }

    public function updated(RelatorioExaustao $relatorio_exaustao)
    {
        //gravar transacao
        $beforeData = $relatorio_exaustao->getOriginal();
        $laterData = $relatorio_exaustao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'relatorios_exaustoes', $beforeData, $laterData);
    }

    public function deleted(RelatorioExaustao $relatorio_exaustao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'relatorios_exaustoes', $relatorio_exaustao, $relatorio_exaustao);
    }
}
