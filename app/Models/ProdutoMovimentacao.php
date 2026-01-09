<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ProdutoMovimentacao extends Model
{
    use HasFactory;

    protected $table = 'produtos_movimentacoes';

    protected $fillable = [
        'origem_estoque_local_id',
        'destino_estoque_local_id',
        'data_movimentacao',
        'hora_movimentacao',
        'tipo',
        'observacoes'
    ];

    protected $dates = [
        'data_movimentacao'
    ];

    public function setDataMovimentacaoAttribute($value) {if ($value != '') {$this->attributes['data_movimentacao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
