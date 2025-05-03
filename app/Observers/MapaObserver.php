<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Mapa;

class MapaObserver
{
    public function created(Mapa $mapa)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'mapas', $mapa, $mapa);
    }

    public function updated(Mapa $mapa)
    {
        //gravar transacao
        $beforeData = $mapa->getOriginal();
        $laterData = $mapa->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'mapas', $beforeData, $laterData);
    }

    public function deleted(Mapa $mapa)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'mapas', $mapa, $mapa);
    }
}
