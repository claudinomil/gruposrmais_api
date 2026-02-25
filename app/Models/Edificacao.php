<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Edificacao extends Model
{
    use HasFactory;

    protected $table = 'edificacoes';

    protected $fillable = [
        'cliente_id',
        'cliente_nome',
        'cliente_telefone',
        'cliente_celular',
        'cliente_email',
        'cliente_logradouro',
        'cliente_bairro',
        'cliente_cidade',
        'name',
        'pavimentos',
        'mezaninos',
        'coberturas',
        'areas_tecnicas',
        'altura',
        'area_total_construida',
        'lotacao',
        'carga_incendio',
        'incendio_risco_id',
        'edificacao_classificacao_id',
        'grupo',
        'ocupacao_uso',
        'divisao',
        'descricao',
        'definicao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setPavimentosAttribute($value) {if ($value != '') {$this->attributes['pavimentos'] = $value;} else {$this->attributes['pavimentos'] = 0;}}
    public function setMezaninosAttribute($value) {if ($value != '') {$this->attributes['mezaninos'] = $value;} else {$this->attributes['mezaninos'] = 0;}}
    public function setCoberturasAttribute($value) {if ($value != '') {$this->attributes['coberturas'] = $value;} else {$this->attributes['coberturas'] = 0;}}
    public function setAreasTecnicasAttribute($value) {if ($value != '') {$this->attributes['areas_tecnicas'] = $value;} else {$this->attributes['areas_tecnicas'] = 0;}}

    public function setAlturaAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['altura'] = $value;
        } else {
            $this->attributes['altura'] = 0;
        }
    }
    public function setAreaTotalConstruidaAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['area_total_construida'] = $value;
        } else {
            $this->attributes['area_total_construida'] = 0;
        }
    }
    public function setLotacaoAttribute($value) {if ($value != '') {$this->attributes['lotacao'] = $value;} else {$this->attributes['lotacao'] = 0;}}

    public function setCargaIncendioAttribute($value)
    {
        if ($value != '') {
            $this->attributes['carga_incendio'] = $value;
        } else {
            $this->attributes['carga_incendio'] = 0;
        }
    }




}
