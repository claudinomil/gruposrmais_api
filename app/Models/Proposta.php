<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Proposta extends Model
{
    use HasFactory;

    protected $table = 'propostas';

    protected $fillable = [
        'empresa_id',
        'data_proposta',
        'data_proposta_extenso',
        'numero_proposta',
        'ano_proposta',
        'cliente_id',
        'cliente_nome',
        'cliente_logradouro',
        'cliente_bairro',
        'cliente_cidade',
        'aos_cuidados',
        'texto_acima_tabela_servico',
        'porcentagem_desconto',
        'valor_desconto',
        'valor_desconto_extenso',
        'valor_total',
        'valor_total_extenso',
        'forma_pagamento',
        'paragrafo_1',
        'paragrafo_2',
        'paragrafo_3',
        'paragrafo_4',
        'paragrafo_5',
        'paragrafo_6',
        'paragrafo_7',
        'paragrafo_8',
        'paragrafo_9',
        'paragrafo_10'
    ];

    public function setClienteNomeAttribute($value) {$this->attributes['cliente_nome'] = mb_strtoupper($value);}
    public function setClienteLogradouroAttribute($value) {$this->attributes['cliente_logradouro'] = mb_strtoupper($value);}
    public function setClienteBairroAttribute($value) {$this->attributes['cliente_bairro'] = mb_strtoupper($value);}
    public function setClienteCidadeAttribute($value) {$this->attributes['cliente_cidade'] = mb_strtoupper($value);}
    public function setAosCuidadosAttribute($value) {$this->attributes['aos_cuidados'] = mb_strtoupper($value);}

    public function setDataPropostaAttribute($value) {if ($value != '') {$this->attributes['data_proposta'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}

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




////numero_proposta
//$reg = Proposta::latest()->first();
//
//if ($reg) {
//$numero_proposta = $reg['numero_proposta'] + 1;
//} else {
//    $numero_proposta = 3000;
//}
//
//$request['numero_proposta'] = $numero_proposta;
//
////ano_proposta
//$request['ano_proposta'] = date('Y');






}
