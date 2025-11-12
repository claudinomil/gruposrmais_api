<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Mapa extends Model
{
    use HasFactory;

    protected $table = 'mapas';

    protected $fillable = [
        'ponto_tipo_id',
        'name',
        'descricao',
        'latitude',
        'longitude',
        'icone',
        'data_inicio',
        'data_fim'
    ];


    protected $dates = [
        'data_inicio',
        'data_termino'
    ];

    public function setDataInicioAttribute($value) {if ($value != '') {$this->attributes['data_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataFimAttribute($value) {if ($value != '') {$this->attributes['data_fim'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
