<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppOperacaoSincronizacao extends Model
{
    use HasFactory;

    protected $table = 'app_operacoes_sincronizacao';

    protected $fillable = [
        'id_operacao',
        'tabela',
        'registro_id',
        'operacao',
        'status_http',
        'resposta',
    ];

    protected $casts = [
        'resposta' => 'array',
    ];
}
