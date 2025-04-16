<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoServico extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_servicos';

    protected $fillable = [
        'ordem_servico_id',
        'servico_id',
        'servico_nome',
        'responsavel_funcionario_id',
        'responsavel_funcionario_nome',
        'servico_item',
        'servico_valor',
        'servico_quantidade',
        'servico_valor_total'
    ];
}
