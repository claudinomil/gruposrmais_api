<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteLocal extends Model
{
    use HasFactory;

    protected $table = 'clientes_locais';

    protected $fillable = [
        'cliente_id',
        'name',
        'descricao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
