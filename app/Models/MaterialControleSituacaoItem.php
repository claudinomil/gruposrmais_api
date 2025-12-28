<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MaterialControleSituacaoItem extends Model
{
    use HasFactory;

    protected $table = 'materiais_controle_situacoes_itens';

    protected $fillable = [
        'material_entrada_item_id',
        'anterior_material_situacao_id',
        'atual_material_situacao_id',
        'anterior_estoque_local_id',
        'atual_estoque_local_id',
        'observacao',
        'data_alteracao'
    ];

    protected $dates = [
        'data_alteracao'
    ];

    public function setDataAlteracaoAttribute($value) {if ($value != '') {$this->attributes['data_alteracao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
