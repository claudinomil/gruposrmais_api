<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaTecnicaDado extends Model
{
    use HasFactory;

    protected $table = 'visitas_tecnicas_dados';

    protected $fillable = [
        'visita_tecnica_id',
        'ordem',
        'titulo',
        'subtitulo',
        'pergunta',
        'respostas',
        'resposta',
        'observacao',
        'fotografia_1',
        'fotografia_2',
        'fotografia_3'
    ];
}
