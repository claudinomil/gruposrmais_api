<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\ClienteLocal;

class ClienteLocalObserver
{
    public function created(ClienteLocal $cliente_local)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'clientes_locais', $cliente_local, $cliente_local);
    }

    public function updated(ClienteLocal $cliente_local)
    {
        //gravar transacao
        $beforeData = $cliente_local->getOriginal();
        $laterData = $cliente_local->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'clientes_locais', $beforeData, $laterData);
    }

    public function deleted(ClienteLocal $cliente_local)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'clientes_locais', $cliente_local, $cliente_local);
    }
}
