<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\MaterialEntrada;

class MaterialEntradaObserver
{
    public function created(MaterialEntrada $material_entrada)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'materiais_entradas', $material_entrada, $material_entrada);
    }

    public function updated(MaterialEntrada $material_entrada)
    {
        //gravar transacao
        $beforeData = $material_entrada->getOriginal();
        $laterData = $material_entrada->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'materiais_entradas', $beforeData, $laterData);
    }

    public function deleted(MaterialEntrada $material_entrada)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'materiais_entradas', $material_entrada, $material_entrada);
    }
}
