<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Edificacao;

class EdificacaoObserver
{
    public function created(Edificacao $edificacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'edificacoes', $edificacao, $edificacao);
    }

    public function updated(Edificacao $edificacao)
    {
        //gravar transacao
        $beforeData = $edificacao->getOriginal();
        $laterData = $edificacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'edificacoes', $beforeData, $laterData);
    }

    public function deleted(Edificacao $edificacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'edificacoes', $edificacao, $edificacao);
    }
}
