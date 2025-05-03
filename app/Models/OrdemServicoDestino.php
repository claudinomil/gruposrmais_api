<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class OrdemServicoDestino extends Model
{
    use HasFactory;

    protected $table = 'ordens_servicos_destinos';

    protected $fillable = [
        'ordem_servico_id',
        'destino_ordem',
        'destino_cep',
        'destino_logradouro',
        'destino_bairro',
        'destino_localidade',
        'destino_uf',
        'destino_numero',
        'destino_complemento',
        'destino_data_agendada',
        'destino_hora_agendada',
        'destino_data_inicio',
        'destino_hora_inicio',
        'destino_data_termino',
        'destino_hora_termino'
    ];

    public function setDestinoDataAgendadaAttribute($value) {if ($value != '') {$this->attributes['destino_data_agendada'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDestinoDataInicioAttribute($value) {if ($value != '') {$this->attributes['destino_data_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDestinoDataTerminoAttribute($value) {if ($value != '') {$this->attributes['destino_data_termino'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
