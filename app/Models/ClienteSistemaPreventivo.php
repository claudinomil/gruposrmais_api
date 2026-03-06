<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteSistemaPreventivo extends Model
{
    use HasFactory;

    protected $table = 'clientes_sistemas_preventivos';

    protected $fillable = [
        'cliente_id',
        'medida_seguranca_id',
        'name',
        'sistema_preventivo_numero',
        'descricao',
        'fotografia'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
