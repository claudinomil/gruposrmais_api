<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoExecutivo extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_executivos';

    protected $fillable = [
        'ordem_servico_id',
        'cliente_executivo_id',
        'cliente_executivo_nome',
        'cliente_executivo_funcao',
        'cliente_executivo_item',
        'cliente_executivo_veiculo_id',
    ];
}
