<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $fillable = [
        'empresa_id',
        'veiculo_marca_id',
        'veiculo_modelo_id',
        'placa',
        'renavam',
        'chassi',
        'ano_modelo',
        'ano_fabricacao',
        'cor',
        'veiculo_combustivel_id',
        'gnv',
        'blindado',
        'veiculo_categoria_id'
    ];
}
