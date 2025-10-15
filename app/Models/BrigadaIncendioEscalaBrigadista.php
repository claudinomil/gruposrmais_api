<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaIncendioEscalaBrigadista extends Model
{
    use HasFactory;

    protected $table = 'brigadas_incendios_escalas_brigadistas';

    protected $fillable = [
        'brigada_incendio_escala_id',
        'funcionario_id',
        'funcionario_name',
        'ala'
    ];

    protected $dates = [];
}