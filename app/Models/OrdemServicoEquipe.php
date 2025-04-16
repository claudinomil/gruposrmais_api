<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoEquipe extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_equipes';

    protected $fillable = [
        'ordem_servico_id',
        'equipe_funcionario_id',
        'equipe_funcionario_item',
        'equipe_funcionario_nome',
        'equipe_funcionario_funcao',
        'equipe_funcionario_veiculo_id'
    ];
}
