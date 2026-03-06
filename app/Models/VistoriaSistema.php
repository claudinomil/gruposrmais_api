<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class VistoriaSistema extends Model
{
    use HasFactory;

    protected $table = 'vistorias_sistemas';

    protected $fillable = [
        'empresa_id',
        'numero_vistoria_sistema',
        'ano_vistoria_sistema',
        'vistoria_sistema_status_id',
        'data_abertura',
        'hora_abertura',
        'data_prevista',
        'hora_prevista',
        'data_conclusao',
        'hora_conclusao',
        'data_finalizacao',
        'hora_finalizacao',

        'cliente_id',
        'cliente_nome',
        'cliente_telefone',
        'cliente_celular',
        'cliente_email',
        'cliente_logradouro',
        'cliente_bairro',
        'cliente_cidade',

        'edificacao_id',
        'edificacao_nome',
        'edificacao_pavimentos',
        'edificacao_mezaninos',
        'edificacao_coberturas',
        'edificacao_areas_tecnicas',
        'edificacao_altura',
        'edificacao_area_total_construida',
        'edificacao_lotacao',
        'edificacao_carga_incendio',
        'edificacao_incendio_risco',
        'edificacao_grupo',
        'edificacao_ocupacao_uso',
        'edificacao_divisao',
        'edificacao_descricao',
        'edificacao_definicao',
        'responsavel_funcionario_id',
        'responsavel_funcionario_nome',
        'responsavel_funcionario_email'
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
