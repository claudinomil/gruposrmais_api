<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\ClienteSistemaPreventivo;
use App\Models\Edificacao;
use App\Models\SistemaPreventivo;

class AppController extends Controller
{
    // Clientes - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Clientes - Início''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    public function clientes_registros()
    {
        $registros = Cliente::leftjoin('edificacoes', 'edificacoes.cliente_id', 'clientes.id')
            ->select('clientes.*', 'edificacoes.id as edificacaoId', 'edificacoes.name as edificacaoName')
            ->orderby('name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }

    public function clientes_edificacao_sistemas_preventivos($edificacao_id)
    {
        $registros = Edificacao::join('edificacoes_niveis', 'edificacoes_niveis.edificacao_id', 'edificacoes.id')
            ->join('edificacoes_locais', 'edificacoes_locais.edificacao_nivel_id', 'edificacoes_niveis.id')
            ->join('clientes_sistemas_preventivos', 'clientes_sistemas_preventivos.edificacao_local_id', 'edificacoes_locais.id')
            ->join('sistemas_preventivos', 'sistemas_preventivos.id', 'clientes_sistemas_preventivos.sistema_preventivo_id')
            ->join('medidas_seguranca', 'medidas_seguranca.id', 'sistemas_preventivos.medida_seguranca_id')
            ->select(
                'clientes_sistemas_preventivos.id as clienteSistemaPreventivoId',
                'clientes_sistemas_preventivos.sistema_preventivo_numero',
                'clientes_sistemas_preventivos.descricao',
                'clientes_sistemas_preventivos.fotografia',
                'sistemas_preventivos.name as sistemaPreventivoName',
                'medidas_seguranca.name as medidaSegurancaName',
                'edificacoes_locais.name as edificacaoLocalName',
                'edificacoes_niveis.name as edificacaoNivelName',
                'edificacoes.name as edificacaoName'
            )
            ->where('edificacoes.id', $edificacao_id)
            ->orderby('edificacoes_niveis.ordem')
            ->orderby('edificacoes_locais.name')
            ->orderby('medidas_seguranca.name')
            ->orderby('sistemas_preventivos.name')
            ->get();

        return $this->sendResponse('Lista de dados enviada com sucesso.', 2000, null, $registros);
    }
    // Clientes - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
    // Clientes - Fim'''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''''
}
