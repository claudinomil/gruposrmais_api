<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoVeiculo extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_veiculos';

    protected $fillable = [
        'ordem_servico_id',
        'veiculo_id',
        'veiculo_item',
        'veiculo_marca',
        'veiculo_modelo',
        'veiculo_placa',
        'veiculo_combustivel'
    ];
}
