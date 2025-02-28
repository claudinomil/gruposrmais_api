<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Escolaridade;

class EscolaridadeObserver
{
    public function created(Escolaridade $escolaridade)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'escolaridades', $escolaridade, $escolaridade);
    }

    public function updated(Escolaridade $escolaridade)
    {
        //gravar transacao
        $beforeData = $escolaridade->getOriginal();
        $laterData = $escolaridade->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'escolaridades', $beforeData, $laterData);
    }

    public function deleted(Escolaridade $escolaridade)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'escolaridades', $escolaridade, $escolaridade);
    }
}
