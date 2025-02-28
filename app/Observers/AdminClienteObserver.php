<?php

namespace App\Observers;

use App\Facades\Transacoes;
use App\Models\AdminCliente;

class AdminClienteObserver
{
    public function created(AdminCliente $admin_cliente)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 1, 'admin_clientes', $admin_cliente, $admin_cliente);
    }

    public function updated(AdminCliente $admin_cliente)
    {
        //gravar transacao
        $beforeData = $admin_cliente->getOriginal();
        $laterData = $admin_cliente->getAttributes();

        Transacoes::transacaoRecord(1, 2, 'admin_clientes', $beforeData, $laterData);
    }

    public function deleted(AdminCliente $admin_cliente)
    {
        //gravar transacao
        Transacoes::transacaoRecord(1, 3, 'admin_clientes', $admin_cliente, $admin_cliente);
    }
}
