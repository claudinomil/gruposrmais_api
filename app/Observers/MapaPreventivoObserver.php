<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\MapaPreventivo;

class MapaPreventivoObserver
{
    public function created(MapaPreventivo $mapa_preventivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'mapas_preventivos', $mapa_preventivo, $mapa_preventivo);
    }

    public function updated(MapaPreventivo $mapa_preventivo)
    {
        //gravar transacao
        $beforeData = $mapa_preventivo->getOriginal();
        $laterData = $mapa_preventivo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'mapas_preventivos', $beforeData, $laterData);
    }

    public function deleted(MapaPreventivo $mapa_preventivo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'mapas_preventivos', $mapa_preventivo, $mapa_preventivo);
    }
}
