<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\PontoInteresse;

class PontoInteresseObserver
{
    public function created(PontoInteresse $ponto_interesse)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'pontos_interesse', $ponto_interesse, $ponto_interesse);
    }

    public function updated(PontoInteresse $ponto_interesse)
    {
        //gravar transacao
        $beforeData = $ponto_interesse->getOriginal();
        $laterData = $ponto_interesse->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'pontos_interesse', $beforeData, $laterData);
    }

    public function deleted(PontoInteresse $ponto_interesse)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'pontos_interesse', $ponto_interesse, $ponto_interesse);
    }
}
