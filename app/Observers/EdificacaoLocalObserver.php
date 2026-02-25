<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\EdificacaoLocal;

class EdificacaoLocalObserver
{
    public function created(EdificacaoLocal $edificacao_local)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'edificacoes_locais', $edificacao_local, $edificacao_local);
    }

    public function updated(EdificacaoLocal $edificacao_local)
    {
        //gravar transacao
        $beforeData = $edificacao_local->getOriginal();
        $laterData = $edificacao_local->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'edificacoes_locais', $beforeData, $laterData);
    }

    public function deleted(EdificacaoLocal $edificacao_local)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'edificacoes_locais', $edificacao_local, $edificacao_local);
    }
}
