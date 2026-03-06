<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteLoja extends Model
{
    use HasFactory;

    protected $table = 'clientes_lojas';

    protected $fillable = [
        'edificacao_nivel_id',
        'luc',
        'ordem',
        'subordinado_cliente_id'
    ];

    protected $dates = [];
}
