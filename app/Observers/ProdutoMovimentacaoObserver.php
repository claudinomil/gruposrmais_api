<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\ProdutoMovimentacao;

class ProdutoMovimentacaoObserver
{
    public function created(ProdutoMovimentacao $produto_movimentacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'produtos_movimentacoes', $produto_movimentacao, $produto_movimentacao);
    }

    public function updated(ProdutoMovimentacao $produto_movimentacao)
    {
        //gravar transacao
        $beforeData = $produto_movimentacao->getOriginal();
        $laterData = $produto_movimentacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'produtos_movimentacoes', $beforeData, $laterData);
    }

    public function deleted(ProdutoMovimentacao $produto_movimentacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'produtos_movimentacoes', $produto_movimentacao, $produto_movimentacao);
    }
}
