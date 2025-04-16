<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Veiculo;

class VeiculoObserver
{
    public function created(Veiculo $veiculo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'veiculos', $veiculo, $veiculo);
    }

    public function updated(Veiculo $veiculo)
    {
        //gravar transacao
        $beforeData = $veiculo->getOriginal();
        $laterData = $veiculo->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'veiculos', $beforeData, $laterData);
    }

    public function deleted(Veiculo $veiculo)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'veiculos', $veiculo, $veiculo);
    }
}
