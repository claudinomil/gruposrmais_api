<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaUniformeDado extends Model
{
    use HasFactory;

    protected $table = 'entregas_uniformes_dados';

    protected $fillable = [
        'entrega_uniforme_id',
        'funcionario_id',
        'funcionario_nome',
        'uniforme_id',
        'uniforme_nome',
        'quantidade',
        'tamanho',
        'data_entrega'
    ];

    protected $dates = [
        'data_entrega'
    ];

    public function setDataEntregaAttribute($value) {if ($value != '') {$this->attributes['data_entrega'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
