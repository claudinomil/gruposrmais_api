<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstoqueLocal extends Model
{
    use HasFactory;

    protected $table = 'estoques_locais';

    protected $fillable = [
        'estoque_id',
        'empresa_id',
        'cliente_id',
        'name',
        'descricao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
