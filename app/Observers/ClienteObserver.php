<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Cliente;

class ClienteObserver
{
    public function created(Cliente $cliente)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'clientes', $cliente, $cliente);
    }

    public function updated(Cliente $cliente)
    {
        //gravar transacao
        $beforeData = $cliente->getOriginal();
        $laterData = $cliente->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'clientes', $beforeData, $laterData);
    }

    public function deleted(Cliente $cliente)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'clientes', $cliente, $cliente);
    }
}
