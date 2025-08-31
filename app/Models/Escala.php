<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Escala extends Model
{
    use HasFactory;

    protected $table = 'escalas';

    protected $fillable = [
        'cliente_id',
        'escala_tipo_id',
        'escala_jornada_id',
        'tipo_name',
        'jornada_name',
        'quantidade_alas',
        'quantidade_horas',
        'quantidade_integrantes',
        'quantidade_integrantes_ala',
        'hora_inicio_ala'
    ];

    protected $dates = [];
}
