<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class APAGARVT extends Model
{
    use HasFactory;

    protected $table = 'visitas_tecnicas';

    protected $fillable = [
        'empresa_id',
        'cliente_servico_id',
        'numero_pavimentos',
        'altura',
        'area_total_construida',
        'lotacao',
        'carga_incendio',
        'incendio_risco',
        'grupo',
        'ocupacao_uso',
        'divisao',
        'descricao',
        'definicao',
        'projeto_scip',
        'projeto_scip_numero',
        'laudo_exigencias',
        'laudo_exigencias_numero',
        'laudo_exigencias_data_emissao',
        'laudo_exigencias_data_vencimento',
        'certificado_aprovacao',
        'certificado_aprovacao_numero',
        'certificado_aprovacao_simplificado',
        'certificado_aprovacao_simplificado_numero',
        'certificado_aprovacao_assistido',
        'certificado_aprovacao_assistido_numero',
        'executado_data',
        'executado_user_id'
    ];

    protected function setLaudoExigenciasDataEmissaoAttribute($value) {
        if ($value != '') {
            $this->attributes['laudo_exigencias_data_emissao'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['laudo_exigencias_data_emissao'] = null;
        }
    }
    protected function getLaudoExigenciasDataEmissaoAttribute($value) {
        if ($value !== null) {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function setLaudoExigenciasDataVencimentoAttribute($value) {
        if ($value != '') {
            $this->attributes['laudo_exigencias_data_vencimento'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['laudo_exigencias_data_vencimento'] = null;
        }
    }
    protected function getLaudoExigenciasDataVencimentoAttribute($value) {
        if ($value !== null) {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    protected function setExecutadoDataAttribute($value) {
        if ($value != '') {
            $this->attributes['executado_data'] = \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } else {
            $this->attributes['executado_data'] = null;
        }
    }
    protected function getExecutadoDataAttribute($value) {
        if ($value !== null) {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }
}
