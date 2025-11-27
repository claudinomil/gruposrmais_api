<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grafico extends Model
{
    use HasFactory;

    protected $table = 'graficos';

    protected $fillable = [
        'name',
        'dashboard',
        'tipo',
        'ordem_visualizacao'
    ];
}