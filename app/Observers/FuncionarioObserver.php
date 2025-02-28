<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\Funcionario;

class FuncionarioObserver
{
    public function created(Funcionario $funcionario)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'funcionarios', $funcionario, $funcionario);
    }

    public function updated(Funcionario $funcionario)
    {
        //gravar transacao
        $beforeData = $funcionario->getOriginal();
        $laterData = $funcionario->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'funcionarios', $beforeData, $laterData);
    }

    public function deleted(Funcionario $funcionario)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'funcionarios', $funcionario, $funcionario);
    }
}
