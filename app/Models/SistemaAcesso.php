<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaAcesso extends Model
{
    use HasFactory;

    protected $table = 'sistema_acessos';

    protected $fillable = [
        'name'
    ];
}
