<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaRondaSegurancaMedida extends Model
{
    use HasFactory;

    protected $table = 'brigadas_rondas_seguranca_medidas';

    protected $fillable = [
        'brigada_ronda_id',
        'pavimento',
        'seguranca_medida_id',
        'seguranca_medida_nome',
        'seguranca_medida_quantidade',
        'seguranca_medida_tipo',
        'seguranca_medida_observacao',
        'status',
        'observacao',
        'foto'
    ];

    protected function setSegurancaMedidaQuantidadeAttribute($value)
    {
        if ($value == '') {
            $this->attributes['seguranca_medida_quantidade'] = NULL;
        } else {
            if ($value !== null) {
                $this->attributes['seguranca_medida_quantidade'] = $value;
            }
        }
    }

    protected function setSegurancaMedidaTipoAttribute($value)
    {
        if ($value == '') {
            $this->attributes['seguranca_medida_tipo'] = NULL;
        } else {
            if ($value !== null) {
                $this->attributes['seguranca_medida_tipo'] = $value;
            }
        }
    }

    protected function setSegurancaMedidaObservacaoAttribute($value)
    {
        if ($value == '') {
            $this->attributes['seguranca_medida_observacao'] = NULL;
        } else {
            if ($value !== null) {
                $this->attributes['seguranca_medida_observacao'] = $value;
            }
        }
    }
}
