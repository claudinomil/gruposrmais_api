<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PontoNatureza extends Model
{
    use HasFactory;

    protected $table = 'pontos_naturezas';

    protected $fillable = [
        'name'
    ];
}