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
        'material_quantidade',
        'material_valor_unitario'
    ];

    public function setMaterialQuantidadeAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['material_quantidade'] = $value;
        } else {
            $this->attributes['material_quantidade'] = 0;
        }
    }

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
