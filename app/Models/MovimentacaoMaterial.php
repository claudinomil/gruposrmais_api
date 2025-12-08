<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MovimentacaoMaterial extends Model
{
    use HasFactory;

    protected $table = 'movimentacoes_materiais';

    protected $fillable = [
        'material_id',
        'origem_cliente_id',
        'origem_local_id',
        'destino_cliente_id',
        'destino_local_id',
        'tipo',
        'quantidade',
        'data_movimentacao',
        'observacoes'
    ];

    protected $dates = [
        'data_movimentacao'
    ];

    public function setDataMovimentacaoAttribute($value) {if ($value != '') {$this->attributes['data_movimentacao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}

    public function setQuantidadeAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['quantidade'] = $value;
        } else {
            $this->attributes['quantidade'] = 0;
        }
    }
}
