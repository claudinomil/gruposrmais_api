<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteExecutivo extends Model
{
    use HasFactory;

    protected $table = 'clientes_executivos';

    protected $fillable = [
        'cliente_id',
        'executivo_nome',
        'executivo_funcao'
    ];

    public function setExecutivoNomeAttribute($value) {$this->attributes['executivo_nome'] = mb_strtoupper($value);}
    public function setExecutivoFuncaoAttribute($value) {$this->attributes['executivo_funcao'] = mb_strtoupper($value);}
}
