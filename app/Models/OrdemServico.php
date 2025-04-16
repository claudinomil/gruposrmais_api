<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OrdemServico extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos';

    protected $fillable = [
        'empresa_id',
        'ordem_servico_tipo_id',
        'numero_ordem_servico',
        'ano_ordem_servico',
        'data_abertura',
        'hora_abertura',
        'data_prevista',
        'hora_prevista',
        'data_conclusao',
        'hora_conclusao',
        'data_finalizacao',
        'hora_finalizacao',
        'ordem_servico_status_id',
        'cliente_id',
        'cliente_nome',
        'cliente_telefone',
        'cliente_celular',
        'cliente_email',
        'cliente_logradouro',
        'cliente_bairro',
        'cliente_cidade',
        'descricao_servico',
        'ordem_servico_prioridade_id',
        'observacao',
        'valor_total',
        'valor_total_extenso',
        'porcentagem_desconto',
        'valor_desconto',
        'valor_desconto_extenso',
        'forma_pagamento_id',
        'forma_pagamento_status_id',
        'forma_pagamento_observacao'
    ];

    protected $dates = [
        'data_abertura',
        'data_prevista',
        'data_conclusao',
        'data_finalizacao'
    ];

    public function setDataAberturaAttribute($value) {if ($value != '') {$this->attributes['data_abertura'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataPrevistaAttribute($value) {if ($value != '') {$this->attributes['data_prevista'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataConclusaoAttribute($value) {if ($value != '') {$this->attributes['data_conclusao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataFinalizacaoAttribute($value) {if ($value != '') {$this->attributes['data_finalizacao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setClienteNomeAttribute($value) {$this->attributes['cliente_nome'] = mb_strtoupper($value);}
    public function setClienteEmailAttribute($value) {$this->attributes['cliente_email'] = mb_strtolower($value);}

    public function setValorTotalAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['valor_total'] = $value;
        } else {
            $this->attributes['valor_total'] = 0;
        }
    }

    public function setPorcentagemDescontoAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['porcentagem_desconto'] = $value;
        } else {
            $this->attributes['porcentagem_desconto'] = 0;
        }
    }

    public function setValorDescontoAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['valor_desconto'] = $value;
        } else {
            $this->attributes['valor_desconto'] = 0;
        }
    }
}
