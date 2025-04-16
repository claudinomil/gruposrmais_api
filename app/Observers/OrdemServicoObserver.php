<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\OrdemServico;

class OrdemServicoObserver
{
    public function created(OrdemServico $ordem_servico)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'ordens_servicos', $ordem_servico, $ordem_servico);
    }

    public function updated(OrdemServico $ordem_servico)
    {
        //gravar transacao
        $beforeData = $ordem_servico->getOriginal();
        $laterData = $ordem_servico->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'ordens_servicos', $beforeData, $laterData);
    }

    public function deleted(OrdemServico $ordem_servico)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'ordens_servicos', $ordem_servico, $ordem_servico);
    }
}
