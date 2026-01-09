<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProdutoMovimentacaoItem extends Model
{
    use HasFactory;

    protected $table = 'produtos_movimentacoes_itens';

    protected $fillable = [
        'produto_movimentacao_id',
        'produto_entrada_item_id'
    ];

    protected $dates = [];
}
