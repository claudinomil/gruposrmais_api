<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\MapaPontoInteresse;

class MapaPontoInteresseObserver
{
    public function created(MapaPontoInteresse $mapa_ponto_interesse)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'mapas_pontos_interesse', $mapa_ponto_interesse, $mapa_ponto_interesse);
    }

    public function updated(MapaPontoInteresse $mapa_ponto_interesse)
    {
        //gravar transacao
        $beforeData = $mapa_ponto_interesse->getOriginal();
        $laterData = $mapa_ponto_interesse->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'mapas_pontos_interesse', $beforeData, $laterData);
    }

    public function deleted(MapaPontoInteresse $mapa_ponto_interesse)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'mapas_pontos_interesse', $mapa_ponto_interesse, $mapa_ponto_interesse);
    }
}
