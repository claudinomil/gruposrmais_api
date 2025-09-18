<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Material;

class MaterialObserver
{
    public function created(Material $material)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'materiais', $material, $material);
    }

    public function updated(Material $material)
    {
        //gravar transacao
        $beforeData = $material->getOriginal();
        $laterData = $material->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'materiais', $beforeData, $laterData);
    }

    public function deleted(Material $material)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'materiais', $material, $material);
    }
}
