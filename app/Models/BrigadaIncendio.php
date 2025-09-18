<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class BrigadaIncendio extends Model
{
    use HasFactory;

    protected $table = 'brigadas_incendios';

    protected $fillable = [
        'empresa_id',
        'cliente_id',
        'numero_brigada_incendio',
        'ano_brigada_incendio',
        'data_abertura',
        'hora_abertura',
        'data_prevista',
        'hora_prevista',
        'data_conclusao',
        'hora_conclusao',
        'data_finalizacao',
        'hora_finalizacao',
        'cliente_nome',
        'cliente_cnpj',
        'cliente_email',
        'cliente_telefone',
        'cliente_celular',
        'cliente_logradouro',
        'cliente_bairro',
        'cliente_logradouro_numero',
        'cliente_logradouro_complemento',
        'cliente_cidade',
        'cliente_uf'
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
}