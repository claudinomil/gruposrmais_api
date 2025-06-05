<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\VisitaTecnica;

class VisitaTecnicaObserver
{
    public function created(VisitaTecnica $visita_tecnica)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'visitas_tecnicas', $visita_tecnica, $visita_tecnica);
    }

    public function updated(VisitaTecnica $visita_tecnica)
    {
        //gravar transacao
        $beforeData = $visita_tecnica->getOriginal();
        $laterData = $visita_tecnica->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'visitas_tecnicas', $beforeData, $laterData);
    }

    public function deleted(VisitaTecnica $visita_tecnica)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'visitas_tecnicas', $visita_tecnica, $visita_tecnica);
    }
}
