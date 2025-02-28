<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Funcao;

class FuncaoObserver
{
    public function created(Funcao $funcao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'funcoes', $funcao, $funcao);
    }

    public function updated(Funcao $funcao)
    {
        //gravar transacao
        $beforeData = $funcao->getOriginal();
        $laterData = $funcao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'funcoes', $beforeData, $laterData);
    }

    public function deleted(Funcao $funcao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'funcoes', $funcao, $funcao);
    }
}
