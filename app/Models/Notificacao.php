<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Notificacao extends Model
{
    use HasFactory;

    protected $table = 'notificacoes';

    protected $fillable = [
        'empresa_id',
        'date',
        'time',
        'title',
        'notificacao',
        'user_id'
    ];
}
