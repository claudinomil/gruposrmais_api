<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\ProdutoEntrada;

class ProdutoEntradaObserver
{
    public function created(ProdutoEntrada $produto_entrada)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'produtos_entradas', $produto_entrada, $produto_entrada);
    }

    public function updated(ProdutoEntrada $produto_entrada)
    {
        //gravar transacao
        $beforeData = $produto_entrada->getOriginal();
        $laterData = $produto_entrada->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'produtos_entradas', $beforeData, $laterData);
    }

    public function deleted(ProdutoEntrada $produto_entrada)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'produtos_entradas', $produto_entrada, $produto_entrada);
    }
}
