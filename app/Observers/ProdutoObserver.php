<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Produto;

class ProdutoObserver
{
    public function created(Produto $produto)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'produtos', $produto, $produto);
    }

    public function updated(Produto $produto)
    {
        //gravar transacao
        $beforeData = $produto->getOriginal();
        $laterData = $produto->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'produtos', $beforeData, $laterData);
    }

    public function deleted(Produto $produto)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'produtos', $produto, $produto);
    }
}
