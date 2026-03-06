<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\VistoriaSistema;

class VistoriaSistemaObserver
{
    public function created(VistoriaSistema $vistoria_sistema)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'vistorias_sistemas', $vistoria_sistema, $vistoria_sistema);
    }

    public function updated(VistoriaSistema $vistoria_sistema)
    {
        //gravar transacao
        $beforeData = $vistoria_sistema->getOriginal();
        $laterData = $vistoria_sistema->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'vistorias_sistemas', $beforeData, $laterData);
    }

    public function deleted(VistoriaSistema $vistoria_sistema)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'vistorias_sistemas', $vistoria_sistema, $vistoria_sistema);
    }
}
