<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaTecnicaPergunta extends Model
{
    use HasFactory;

    protected $table = 'visita_tecnica_perguntas';

    protected $fillable = [
        'visita_tecnica_tipo_id',
        'ordem',
        'titulo',
        'subtitulo',
        'pergunta',
        'respostas'
    ];
}
