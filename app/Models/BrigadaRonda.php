<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaRonda extends Model
{
    use HasFactory;

    protected $table = 'brigadas_rondas';

    protected $fillable = [
        'brigada_escala_id',
        'foto',
        'data_inicio_ronda',
        'hora_inicio_ronda',
        'data_encerramento_ronda',
        'hora_encerramento_ronda'
    ];

    protected function setDataInicioRondaAttribute($value) {
        if ($value != '') {
            if (substr($value, 2, 1) == '/') {
                $this->attributes['data_inicio_ronda'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } else if ($value == '0000-00-00') {
                $this->attributes['data_inicio_ronda'] = null;
            } else {
                $this->attributes['data_inicio_ronda'] = $value;
            }
        } else {
            $this->attributes['data_inicio_ronda'] = null;
        }
    }
    protected function getDataInicioRondaAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function setDataEncerramentoRondaAttribute($value) {
        if ($value != '') {
            if (substr($value, 2, 1) == '/') {
                $this->attributes['data_encerramento_ronda'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
            } else if ($value == '0000-00-00') {
                $this->attributes['data_encerramento_ronda'] = null;
            } else {
                $this->attributes['data_encerramento_ronda'] = $value;
            }
        } else {
            $this->attributes['data_encerramento_ronda'] = null;
        }
    }
    protected function getDataEncerramentoRondaAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }
}
