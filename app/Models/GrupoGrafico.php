<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoGrafico extends Model
{
    use HasFactory;

    protected $table = 'grupos_graficos';

    protected $fillable = [
        'grupo_id',
        'grafico_id'
    ];
}
