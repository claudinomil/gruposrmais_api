<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropostaServico extends Model
{
    use HasFactory;

    protected $table = 'propostas_servicos';

    protected $fillable = [
        'proposta_id',
        'servico_id',
        'servico_item',
        'servico_nome',
        'servico_valor',
        'servico_quantidade',
        'servico_valor_total'
    ];
}
