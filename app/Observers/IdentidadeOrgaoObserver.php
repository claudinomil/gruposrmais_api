<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\IdentidadeOrgao;

class IdentidadeOrgaoObserver
{
    public function created(IdentidadeOrgao $identidade_orgao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'identidade_orgaos', $identidade_orgao, $identidade_orgao);
    }

    public function updated(IdentidadeOrgao $identidade_orgao)
    {
        //gravar transacao
        $beforeData = $identidade_orgao->getOriginal();
        $laterData = $identidade_orgao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'identidade_orgaos', $beforeData, $laterData);
    }

    public function deleted(IdentidadeOrgao $identidade_orgao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'identidade_orgaos', $identidade_orgao, $identidade_orgao);
    }
}
