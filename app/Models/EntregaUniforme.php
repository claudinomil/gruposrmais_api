<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaUniforme extends Model
{
    use HasFactory;

    protected $table = 'entregas_uniformes';

    protected $fillable = [
        'tomador_servico_cliente_id',
        'tomador_servico_cliente_nome',
        'funcao_id',
        'funcao_nome',
        'numero_entrega',
        'data_entrega'
    ];

    protected $dates = [
        'data_entrega'
    ];

    public function setDataEntregaAttribute($value) {if ($value != '') {$this->attributes['data_entrega'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
