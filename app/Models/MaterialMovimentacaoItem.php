<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MaterialMovimentacaoItem extends Model
{
    use HasFactory;

    protected $table = 'materiais_movimentacoes_itens';

    protected $fillable = [
        'material_movimentacao_id',
        'material_entrada_item_id'
    ];

    protected $dates = [];
}
