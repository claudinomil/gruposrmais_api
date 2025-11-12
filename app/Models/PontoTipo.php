<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoTipo extends Model
{
    use HasFactory;

    protected $table = 'pontos_tipos';

    protected $fillable = [
        'name'
    ];
}
