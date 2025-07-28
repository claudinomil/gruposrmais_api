<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'servicos';

    protected $fillable = [
        'name',
        'servico_tipo_id',
        'valor'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}

    public function getValorAttribute($value) {return number_format($value, 2, ',', '.');}
    public function setValorAttribute($value)
    {
        if (strstr($value,'.')) {$value = str_replace('.','',$value);}
        if (strstr($value,',')) {$value = str_replace(',','.',$value);}
        if ($value == '') {$value = 0.00;}

        $this->attributes['valor'] = $value;
    }
}
