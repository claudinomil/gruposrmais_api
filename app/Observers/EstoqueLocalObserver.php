<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\EstoqueLocal;

class EstoqueLocalObserver
{
    public function created(EstoqueLocal $estoque_local)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'estoques_locais', $estoque_local, $estoque_local);
    }

    public function updated(EstoqueLocal $estoque_local)
    {
        //gravar transacao
        $beforeData = $estoque_local->getOriginal();
        $laterData = $estoque_local->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'estoques_locais', $beforeData, $laterData);
    }

    public function deleted(EstoqueLocal $estoque_local)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'estoques_locais', $estoque_local, $estoque_local);
    }
}
