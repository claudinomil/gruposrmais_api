<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\BrigadaIncendio;

class BrigadaIncendioObserver
{
    public function created(BrigadaIncendio $brigada_incendio)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'brigadas_incendios', $brigada_incendio, $brigada_incendio);
    }

    public function updated(BrigadaIncendio $brigada_incendio)
    {
        //gravar transacao
        $beforeData = $brigada_incendio->getOriginal();
        $laterData = $brigada_incendio->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'brigadas_incendios', $beforeData, $laterData);
    }

    public function deleted(BrigadaIncendio $brigada_incendio)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'brigadas_incendios', $brigada_incendio, $brigada_incendio);
    }
}
