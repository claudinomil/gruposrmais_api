<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialEntradaItem extends Model
{
    use HasFactory;

    protected $table = 'materiais_entradas_itens';

    protected $fillable = [
        'material_entrada_id',
        'material_id',
        'material_categoria_name',
        'material_name',
        'material_numero_patrimonio',
        'material_valor_unitario',
        'estoque_local_id'
    ];

    public function setMaterialValorUnitarioAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['material_valor_unitario'] = $value;
        } else {
            $this->attributes['material_valor_unitario'] = 0;
        }
    }
}
