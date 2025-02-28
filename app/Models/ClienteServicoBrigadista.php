<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServicoBrigadista extends Model
{
    use HasFactory;

    protected $table = 'cliente_servicos_brigadistas';

    protected $fillable = [
        'cliente_servico_id',
        'funcionario_id',
        'funcionario_nome',
        'ala'
    ];
}
