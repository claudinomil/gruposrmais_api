<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Banco;

class BancoObserver
{
    public function created(Banco $banco)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'bancos', $banco, $banco);
    }

    public function updated(Banco $banco)
    {
        //gravar transacao
        $beforeData = $banco->getOriginal();
        $laterData = $banco->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'bancos', $beforeData, $laterData);
    }

    public function deleted(Banco $banco)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'bancos', $banco, $banco);
    }
}
