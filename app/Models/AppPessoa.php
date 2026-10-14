<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppPessoa extends Model
{
    use HasFactory;

    protected $table = 'app_pessoas';

    protected $fillable = [
        'nome',
        'apelido'
    ];
}
