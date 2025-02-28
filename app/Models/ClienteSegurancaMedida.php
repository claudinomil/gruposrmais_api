<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ClienteSegurancaMedida extends Model
{
    use HasFactory;

    protected $table = 'clientes_seguranca_medidas';

    protected $fillable = [
        'pavimento',
        'cliente_id',
        'seguranca_medida_id',
        'quantidade',
        'tipo',
        'observacao'
    ];
}
