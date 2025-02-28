<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Empresa;

class EmpresaObserver
{
    public function created(Empresa $empresa)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'empresas', $empresa, $empresa);
    }

    public function updated(Empresa $empresa)
    {
        //gravar transacao
        $beforeData = $empresa->getOriginal();
        $laterData = $empresa->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'empresas', $beforeData, $laterData);
    }

    public function deleted(Empresa $empresa)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'empresas', $empresa, $empresa);
    }
}
