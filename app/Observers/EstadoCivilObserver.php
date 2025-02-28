<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\EstadoCivil;

class EstadoCivilObserver
{
    public function created(EstadoCivil $estadoCivil)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'estados_civis', $estadoCivil, $estadoCivil);
    }

    public function updated(EstadoCivil $estadoCivil)
    {
        //gravar transacao
        $beforeData = $estadoCivil->getOriginal();
        $laterData = $estadoCivil->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'estados_civis', $beforeData, $laterData);
    }

    public function deleted(EstadoCivil $estadoCivil)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'estados_civis', $estadoCivil, $estadoCivil);
    }
}
