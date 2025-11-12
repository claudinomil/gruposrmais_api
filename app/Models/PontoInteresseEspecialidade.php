<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoInteresseEspecialidade extends Model
{
    use HasFactory;

    protected $table = 'pontos_interesse_especialidades';

    protected $fillable = [
        'ponto_interesse_id',
        'especialidade_id'
    ];
}