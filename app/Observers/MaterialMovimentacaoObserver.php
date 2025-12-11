<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\MaterialMovimentacao;

class MaterialMovimentacaoObserver
{
    public function created(MaterialMovimentacao $material_movimentacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'materiais_movimentacoes', $material_movimentacao, $material_movimentacao);
    }

    public function updated(MaterialMovimentacao $material_movimentacao)
    {
        //gravar transacao
        $beforeData = $material_movimentacao->getOriginal();
        $laterData = $material_movimentacao->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'materiais_movimentacoes', $beforeData, $laterData);
    }

    public function deleted(MaterialMovimentacao $material_movimentacao)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'materiais_movimentacoes', $material_movimentacao, $material_movimentacao);
    }
}
