<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteServico extends Model
{
    use HasFactory;

    protected $table = 'clientes_servicos';

    protected $fillable = [
        'cliente_id',
        'servico_id',
        'servico_status_id',
        'responsavel_funcionario_id',
        'quantidade',
        'data_inicio',
        'data_fim',
        'data_vencimento',
        'valor',
        'bi_escala_tipo_id',
        'bi_quantidade_alas_escala',
        'bi_quantidade_brigadistas_por_ala',
        'bi_quantidade_brigadistas_total',
        'bi_hora_inicio_ala'
    ];

    protected function setQuantidadeAttribute($value) {if ($value == '') {$this->attributes['quantidade'] = null;} else {$this->attributes['quantidade'] = $value;}}

//    protected function setDataInicioAttribute($value) {
//        if ($value != '') {
//            $this->attributes['data_inicio'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
//        } else {
//            $this->attributes['data_inicio'] = null;
//        }
//    }
    protected function getDataInicioAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

//    protected function setDataFimAttribute($value) {
//        if ($value != '') {
//            $this->attributes['data_fim'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
//        } else {
//            $this->attributes['data_fim'] = null;
//        }
//    }
    protected function getDataFimAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

//    protected function setDataVencimentoAttribute($value) {
//        if ($value != '') {
//            $this->attributes['data_vencimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
//        } else {
//            $this->attributes['data_vencimento'] = null;
//        }
//    }
    protected function getDataVencimentoAttribute($value) {
        if ($value != '') {
            return \Illuminate\Support\Carbon::parse($value)->format('d/m/Y');
        }
    }

    public function setValorAttribute($value)
    {
        if (strstr($value,'.')) {$value = str_replace('.','',$value);}
        if (strstr($value,',')) {$value = str_replace(',','.',$value);}
        if ($value == '') {$value = 0.00;}

        $this->attributes['valor'] = $value;
    }
    public function getValorAttribute($value) {return number_format($value, 2, ',', '.');}
}
