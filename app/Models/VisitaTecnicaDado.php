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
        'titulo',
        'subtitulo',
        'pergunta',
        'resposta',
        'observacao',
        'quantidade',
        'fotografia_1',
        'fotografia_2',
        'fotografia_3',
        'pdf_1',
        'pdf_2',
        'pdf_3',
        'completa',
        'completa_ordem',
        'sintetica',
        'sintetica_ordem',
        'opcoes'
    ];
}
