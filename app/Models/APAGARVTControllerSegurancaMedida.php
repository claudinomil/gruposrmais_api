<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APAGARVTControllerSegurancaMedida extends Model
{
    use HasFactory;

    protected $table = 'visitas_tecnicas_seguranca_medidas';

    protected $fillable = [
        'pavimento',
        'visita_tecnica_id',
        'seguranca_medida_id',
        'seguranca_medida_nome',
        'seguranca_medida_quantidade',
        'seguranca_medida_tipo',
        'seguranca_medida_observacao',
        'status',
        'observacao'
    ];
}
