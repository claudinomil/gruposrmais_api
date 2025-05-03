<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MapaPontoTipo extends Model
{
    use HasFactory;

    protected $table = 'mapas_pontos_tipos';

    protected $fillable = [
        'name'
    ];
}
