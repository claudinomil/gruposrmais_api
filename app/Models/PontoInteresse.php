<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PontoInteresse extends Model
{
    use HasFactory;

    protected $table = 'pontos_interesse';

    protected $fillable = [
        'ponto_tipo_id',
        'ponto_natureza_id',
        'name',
        'descricao',
        'cep',
        'numero',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'latitude',
        'longitude',
        'icone',
        'telefone_1',
        'telefone_2'
    ];


    protected $dates = [
        'data_inicio',
        'data_termino'
    ];

    public function setDataInicioAttribute($value) {if ($value != '') {$this->attributes['data_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataFimAttribute($value) {if ($value != '') {$this->attributes['data_fim'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
