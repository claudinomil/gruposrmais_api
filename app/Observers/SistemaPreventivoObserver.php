<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\SistemaPreventivo;

class SistemaPreventivoObserver
{
    public function created(SistemaPreventivo $sistema_preventivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'sistemas_preventivos', $sistema_preventivo, $sistema_preventivo);
    }

    public function updated(SistemaPreventivo $sistema_preventivo)
    {
        //gravar transacao
        $beforeData = $sistema_preventivo->getOriginal();
        $laterData = $sistema_preventivo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'sistemas_preventivos', $beforeData, $laterData);
    }

    public function deleted(SistemaPreventivo $sistema_preventivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'sistemas_preventivos', $sistema_preventivo, $sistema_preventivo);
    }
}
