<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\ClienteExecutivo;

class ClienteExecutivoObserver
{
    public function created(ClienteExecutivo $cliente_executivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'clientes_executivos', $cliente_executivo, $cliente_executivo);
    }

    public function updated(ClienteExecutivo $cliente_executivo)
    {
        //gravar transacao
        $beforeData = $cliente_executivo->getOriginal();
        $laterData = $cliente_executivo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'clientes_executivos', $beforeData, $laterData);
    }

    public function deleted(ClienteExecutivo $cliente_executivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'clientes_executivos', $cliente_executivo, $cliente_executivo);
    }
}
