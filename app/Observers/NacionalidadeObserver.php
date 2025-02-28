<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Nacionalidade;

class NacionalidadeObserver
{
    public function created(Nacionalidade $nacionalidade)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'nacionalidades', $nacionalidade, $nacionalidade);
    }

    public function updated(Nacionalidade $nacionalidade)
    {
        //gravar transacao
        $beforeData = $nacionalidade->getOriginal();
        $laterData = $nacionalidade->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'nacionalidades', $beforeData, $laterData);
    }

    public function deleted(Nacionalidade $nacionalidade)
    {
        //gravar transacao
        Transacoes::
        transacaoRecord(1, 3, 'nacionalidades', $nacionalidade, $nacionalidade);
    }
}
