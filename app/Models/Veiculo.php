<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculos';

    protected $fillable = [
        'empresa_id',
        'veiculo_marca_id',
        'veiculo_modelo_id',
        'placa',
        'renavam',
        'chassi',
        'ano_modelo',
        'ano_fabricacao',
        'cor',
        'veiculo_combustivel_id',
        'gnv',
        'blindado',
        'veiculo_categoria_id'
    ];

    public function setPlacaAttribute($value) {$this->attributes['placa'] = mb_strtoupper($value);}
    public function setRenavamAttribute($value) {$this->attributes['renavam'] = mb_strtoupper($value);}
    public function setCorAttribute($value) {$this->attributes['cor'] = mb_strtoupper($value);}
}
