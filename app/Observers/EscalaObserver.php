<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Escala;

class EscalaObserver
{
    public function created(Escala $escala)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'escalas', $escala, $escala);
    }

    public function updated(Escala $escala)
    {
        //gravar transacao
        $beforeData = $escala->getOriginal();
        $laterData = $escala->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'escalas', $beforeData, $laterData);
    }

    public function deleted(Escala $escala)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'escalas', $escala, $escala);
    }
}
