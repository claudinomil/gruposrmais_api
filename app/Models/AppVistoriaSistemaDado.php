<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppVistoriaSistemaDado extends Model
{
    use HasFactory;

    protected $table = 'app_vistorias_sistemas_dados';

    protected $fillable = [
        'app_vistoria_sistema_id',
        'cliente_sistema_preventivo_id',
        'sistema_preventivo_numero',
        'sistema_preventivo_id',
        'sistema_preventivo_nome',
        'edificacao_local_id',
        'edificacao_local_nome',
        'edificacao_nivel_id',
        'edificacao_nivel_nome',
        'resposta',
        'observacao',
        'fotografia_1',
        'fotografia_2',
        'fotografia_3'
    ];
}
