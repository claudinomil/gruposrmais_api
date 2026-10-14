<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AppPessoa;

class AppPessoaObserver
{
    public function created(AppPessoa $app_pessoa)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'app_pessoas', $app_pessoa, $app_pessoa);
    }

    public function updated(AppPessoa $app_pessoa)
    {
        //gravar transacao
        $beforeData = $app_pessoa->getOriginal();
        $laterData = $app_pessoa->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'app_pessoas', $beforeData, $laterData);
    }

    public function deleted(AppPessoa $app_pessoa)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'app_pessoas', $app_pessoa, $app_pessoa);
    }
}
