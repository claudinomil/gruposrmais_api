<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\EquipamentoPreventivo;

class EquipamentoPreventivoObserver
{
    public function created(EquipamentoPreventivo $equipamento_preventivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'equipamentos_preventivos', $equipamento_preventivo, $equipamento_preventivo);
    }

    public function updated(EquipamentoPreventivo $equipamento_preventivo)
    {
        //gravar transacao
        $beforeData = $equipamento_preventivo->getOriginal();
        $laterData = $equipamento_preventivo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'equipamentos_preventivos', $beforeData, $laterData);
    }

    public function deleted(EquipamentoPreventivo $equipamento_preventivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'equipamentos_preventivos', $equipamento_preventivo, $equipamento_preventivo);
    }
}
