<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Genero;

class GeneroObserver
{
    public function created(Genero $genero)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'generos', $genero, $genero);
    }

    public function updated(Genero $genero)
    {
        //gravar transacao
        $beforeData = $genero->getOriginal();
        $laterData = $genero->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'generos', $beforeData, $laterData);
    }

    public function deleted(Genero $genero)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'generos', $genero, $genero);
    }
}
