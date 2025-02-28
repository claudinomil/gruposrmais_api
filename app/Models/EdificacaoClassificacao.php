<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdificacaoClassificacao extends Model
{
    use HasFactory;

    protected $table = 'edificacao_classificacoes';

    protected $fillable = [
        'grupo',
        'ocupacao_uso',
        'divisao',
        'descricao',
        'definicao'
    ];
}
