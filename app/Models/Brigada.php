<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brigada extends Model
{
    use HasFactory;

    protected $table = 'brigadas';

    protected $fillable = [
        'empresa_id',
        'cliente_servico_id'
    ];
}
