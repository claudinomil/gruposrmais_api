<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoFuncionario extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_funcionarios';

    protected $fillable = [
        'ordem_servico_id',
        'funcionario_id',
        'funcionario_nome',
        'funcionario_item',
        'funcionario_veiculo_id',
    ];
}
