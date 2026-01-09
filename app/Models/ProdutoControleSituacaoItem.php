<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProdutoControleSituacaoItem extends Model
{
    use HasFactory;

    protected $table = 'produtos_controle_situacoes_itens';

    protected $fillable = [
        'produto_entrada_item_id',
        'anterior_produto_situacao_id',
        'atual_produto_situacao_id',
        'anterior_estoque_local_id',
        'atual_estoque_local_id',
        'observacao',
        'data_alteracao',
        'hora_alteracao'
    ];

    protected $dates = [
        'data_alteracao'
    ];

    public function setDataAlteracaoAttribute($value) {if ($value != '') {$this->attributes['data_alteracao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
