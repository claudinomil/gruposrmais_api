<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistoriaSistemaDado extends Model
{
    use HasFactory;

    protected $table = 'vistorias_sistemas_dados';

    protected $fillable = [
        'vistoria_sistema_id',
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

    public function setSubtituloAttribute($value) {if ($value == 'null') {$this->attributes['subtitulo'] = NULL;}}
}
