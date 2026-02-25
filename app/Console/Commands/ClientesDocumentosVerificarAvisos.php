<?php

namespace App\Console\Commands;

use App\Facades\Transacoes;
use App\Models\ClienteDocumento;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClientesDocumentosVerificarAvisos extends Command
{
    protected $signature = 'claudino:clientes-documentos-verificar-avisos';
    protected $description = 'Clientes Documentos Verificar Avisos';

    public function handle()
    {
        $hoje = Carbon::today()->toDateString();

        // Buscar registros de aviso : Para data_emissao menor ou igual a data de hoje E data_vencimento menor ou igual a data de hoje
        $avisos = ClienteDocumento
            ::join('clientes', 'clientes.id', 'clientes_documentos.cliente_id')
            ->join('documentos', 'documentos.id', 'clientes_documentos.documento_id')
            ->select('clientes_documentos.*', 'clientes.name as clienteName', 'clientes.email_avisos as clienteEmailAvisos', 'documentos.name as documentoName')
            ->where(function ($q) use ($hoje) {
                $q->whereNull('clientes_documentos.data_ultimo_aviso')->orWhereDate('clientes_documentos.data_ultimo_aviso', '<', $hoje);
            })
            ->whereNotNull('clientes_documentos.data_emissao')
            ->whereDate('clientes_documentos.data_emissao', '<=', $hoje)
            ->whereNotNull('clientes_documentos.data_vencimento')
            ->whereDate('clientes_documentos.data_vencimento', '>=', $hoje)
            ->where('clientes_documentos.aviso', '!=', 0)
            ->get();

        foreach ($avisos as $aviso) {
            // Datas
            $dataDocumento = Carbon::parse($aviso->data_emissao)->startOfDay();
            $dataUltimoAviso = $aviso->data_ultimo_aviso ? Carbon::parse($aviso->data_ultimo_aviso)->startOfDay() : $dataDocumento;
            $dataVencimento = $aviso->data_vencimento ? Carbon::parse($aviso->data_vencimento)->startOfDay() : $dataDocumento;

            // 1 : Avisar a cada 1 mês
            if ($aviso->aviso == 1) {
                $avisoDescricao = '';

                for ($i=30; $i<=99999; $i+=30) {
                    $dataComparacao = $dataDocumento->copy()->addDays($i)->startOfDay();

                    if ($dataComparacao->greaterThan($dataUltimoAviso) && $dataComparacao->lessThanOrEqualTo($dataVencimento)) {
                        // Dados
                        $cliente_name = $aviso->clienteName;
                        $documento_name = $aviso->documentoName;
                        $data_emissao = $aviso->data_emissao;
                        $data_vencimento = $aviso->data_vencimento;
                        $email = $aviso->clienteEmailAvisos;

                        // Verificando E-mail de Avisos
                        if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            // Enviando e-mail
                            Mail::send('emails.clientes_documentos_avisos', ['email' => $email, 'cliente_name' => $cliente_name, 'documento_name' => $documento_name, 'data_emissao' => $data_emissao, 'data_vencimento' => $data_vencimento, 'hoje' => $hoje], function ($message) use($email) {
                                $message->to($email);
                                $message->subject('Aviso de Vencimento de Documento');
                            });

                            // Atualiza tabela clientes_documentos
                            ClienteDocumento::where('id', $aviso->id)->update(['data_ultimo_aviso' => $hoje, 'descricao' => $avisoDescricao]);

                            // PARA SIMULAR: php artisan schedule:work ou rodar direto php artisan claudino:clientes-documentos-verificar-avisos

                            $this->info("Aviso enviado para o cliente ID {$aviso->cliente_id}, Data Aviso {$dataUltimoAviso} e Data Comparação {$dataComparacao}");

                            // Atualizar variavel
                            $dataUltimoAviso = Carbon::parse($hoje)->startOfDay();

                            // Log da Transação
                            $regArray = array();
                            $regArray['cliente_id'] = $aviso->cliente_id;
                            $regArray['documento_id'] = $aviso->documento_id;
                            $regArray['data_emissao'] = $aviso->data_emissao;
                            $regArray['data_vencimento'] = $aviso->data_emissao;
                            $regArray['data_aviso'] = $hoje;
                            $regArray['cliente_email'] = $aviso->clienteEmailAvisos;

                            Transacoes::transacaoRecord(4, 1, 'clientes', $regArray, $regArray, 2);

                            // Sair do Foreach
                            break;
                        } else {

                        }
                    }
                }
            }

            // 2 : Avisar a cada 3 meses
            if ($aviso->aviso == 2) {}

            // 3 : Avisar a cada 6 meses
            if ($aviso->aviso == 3) {}

            // 4 : Avisar a cada 1 ano
            if ($aviso->aviso == 4) {}

            // 5 : Avisar a cada 3 anos
            if ($aviso->aviso == 5) {}

            // 6 : Avisar a cada 6 anos
            if ($aviso->aviso == 6) {}
        }

        return Command::SUCCESS;
    }
}
