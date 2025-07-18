<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VisitaTecnica extends Model
{
    use HasFactory;

    protected $table = 'visitas_tecnicas';

    protected $fillable = [
        'empresa_id',
        'visita_tecnica_tipo_id',
        'numero_visita_tecnica',
        'ano_visita_tecnica',
        'data_abertura',
        'hora_abertura',
        'data_prevista',
        'hora_prevista',
        'data_conclusao',
        'hora_conclusao',
        'data_finalizacao',
        'hora_finalizacao',
        'visita_tecnica_status_id',
        'cliente_id',
        'cliente_nome',
        'cliente_telefone',
        'cliente_celular',
        'cliente_email',
        'cliente_logradouro',
        'cliente_bairro',
        'cliente_cidade'
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
}
