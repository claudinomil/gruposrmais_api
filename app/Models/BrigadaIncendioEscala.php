<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaIncendioEscala extends Model
{
    use HasFactory;

    protected $table = 'brigadas_incendios_escalas';

    protected $fillable = [
        'brigada_incendio_id',
        'escala_tipo_id',
        'escala_tipo_name',
        'escala_tipo_quantidade_alas',
        'escala_tipo_quantidade_horas_trabalhadas',
        'escala_tipo_quantidade_horas_descanso',
        'quantidade_brigadistas_por_ala',
        'quantidade_brigadistas_total',
        'posto',
        'hora_inicio_ala_1'
    ];

    protected $dates = [];
}