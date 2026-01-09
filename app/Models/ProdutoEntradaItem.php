<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoEntradaItem extends Model
{
    use HasFactory;

    protected $table = 'produtos_entradas_itens';

    protected $fillable = [
        'produto_entrada_id',
        'produto_id',
        'produto_categoria_name',
        'produto_name',
        'produto_numero_patrimonio',
        'produto_valor_unitario',
        'estoque_local_id',
        'produto_situacao_id',
        'produto_tipo_id',
        'produto_tipo_name'
    ];

    public function setProdutoValorUnitarioAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['produto_valor_unitario'] = $value;
        } else {
            $this->attributes['produto_valor_unitario'] = 0;
        }
    }
}
