<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaEscala extends Model
{
    use HasFactory;

    protected $table = 'brigadas_escalas';

    protected $fillable = [
        'brigada_id',
        'cliente_id',
        'cliente_nome',
        'escala_tipo_id',
        'escala_tipo_nome',
        'quantidade_alas',
        'quantidade_brigadistas_por_ala',
        'quantidade_brigadistas_total',
        'hora_inicio_ala',
        'data_chegada',
        'hora_chegada',
        'data_saida',
        'hora_saida',
        'funcionario_id',
        'funcionario_nome',
        'ala',
        'escala_frequencia_id',
        'foto_chegada_real',
        'data_chegada_real',
        'hora_chegada_real',
        'foto_saida_real',
        'data_saida_real',
        'hora_saida_real'
    ];

    protected function setDataChegadaAttribute($value) {
        if ($value != '') {
            if (substr($value, 2, 1) == '/') {
                $this->attributes['data_chegada'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } else if ($value == '0000-00-00') {
                $this->attributes['data_chegada'] = null;
            } else {
                $this->attributes['data_chegada'] = $value;
            }
        } else {
            $this->attributes['data_chegada'] = null;
        }
    }
    protected function getDataChegadaAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function getHoraChegadaAttribute($value) {
        if ($value != '') {
            return substr($value, 0, 5);
        }
    }

    protected function setDataSaidaAttribute($value) {
        if ($value != '') {
            if (substr($value, 2, 1) == '/') {
                $this->attributes['data_saida'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } else if ($value == '0000-00-00') {
                $this->attributes['data_saida'] = null;
            } else {
                $this->attributes['data_saida'] = $value;
            }
        } else {
            $this->attributes['data_saida'] = null;
        }
    }
    protected function getDataSaidaAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function getHoraSaidaAttribute($value) {
        if ($value != '') {
            return substr($value, 0, 5);
        }
    }

    protected function setDataChegadaRealAttribute($value) {
        if ($value != '') {
            if (substr($value, 2, 1) == '/') {
                $this->attributes['data_chegada_real'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } else if ($value == '0000-00-00') {
                $this->attributes['data_chegada_real'] = null;
            } else {
                $this->attributes['data_chegada_real'] = $value;
            }
        } else {
            $this->attributes['data_chegada_real'] = null;
        }
    }
    protected function getDataChegadaRealAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function getHoraChegadaRealAttribute($value) {
        if ($value != '') {
            return substr($value, 0, 5);
        }
    }

    protected function setDataSaidaRealAttribute($value) {
        if ($value != '') {
            if (substr($value, 2, 1) == '/') {
                $this->attributes['data_saida_real'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } else if ($value == '0000-00-00') {
                $this->attributes['data_saida_real'] = null;
            } else {
                $this->attributes['data_saida_real'] = $value;
            }
        } else {
            $this->attributes['data_saida_real'] = null;
        }
    }
    protected function getDataSaidaRealAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function getHoraSaidaRealAttribute($value) {
        if ($value != '') {
            return substr($value, 0, 5);
        }
    }
}
