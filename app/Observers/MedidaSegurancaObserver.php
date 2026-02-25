<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\MedidaSeguranca;

class MedidaSegurancaObserver
{
    public function created(MedidaSeguranca $medida_seguranca)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'medidas_seguranca', $medida_seguranca, $medida_seguranca);
    }

    public function updated(MedidaSeguranca $medida_seguranca)
    {
        //gravar transacao
        $beforeData = $medida_seguranca->getOriginal();
        $laterData = $medida_seguranca->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'medidas_seguranca', $beforeData, $laterData);
    }

    public function deleted(MedidaSeguranca $medida_seguranca)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'medidas_seguranca', $medida_seguranca, $medida_seguranca);
    }
}
