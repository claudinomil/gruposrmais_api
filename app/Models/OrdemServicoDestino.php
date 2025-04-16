<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdemServicoDestino extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_destinos';

    protected $fillable = [
        'ordem_servico_id',
        'destino_ordem',
        'destino_cep',
        'destino_logradouro',
        'destino_bairro',
        'destino_localidade',
        'destino_uf',
        'destino_numero',
        'destino_complemento'
    ];
}
