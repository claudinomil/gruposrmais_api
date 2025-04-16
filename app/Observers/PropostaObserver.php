<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Proposta;

class PropostaObserver
{
    public function created(Proposta $proposta)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'propostas', $proposta, $proposta);
    }

    public function updated(Proposta $proposta)
    {
        //gravar transacao
        $beforeData = $proposta->getOriginal();
        $laterData = $proposta->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'propostas', $beforeData, $laterData);
    }

    public function deleted(Proposta $proposta)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'propostas', $proposta, $proposta);
    }
}
