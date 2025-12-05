<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoMensalFuncionario extends Model
{
    use HasFactory;

    protected $table = 'documentos_mensais_funcionarios';

    protected $fillable = [
        'name',
        'ordem'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
