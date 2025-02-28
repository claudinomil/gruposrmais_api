<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Fornecedor;

class FornecedorObserver
{
    public function created(Fornecedor $fornecedor)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'fornecedores', $fornecedor, $fornecedor);
    }

    public function updated(Fornecedor $fornecedor)
    {
        //gravar transacao
        $beforeData = $fornecedor->getOriginal();
        $laterData = $fornecedor->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'fornecedores', $beforeData, $laterData);
    }

    public function deleted(Fornecedor $fornecedor)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'fornecedores', $fornecedor, $fornecedor);
    }
}
