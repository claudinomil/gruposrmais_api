<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraficoGrupo extends Model
{
    use HasFactory;

    protected $table = 'grafico_grupos';

    protected $fillable = [
        'name',
        'ordem_visualizacao'
    ];
}
