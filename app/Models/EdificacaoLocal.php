<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class EdificacaoLocal extends Model
{
    use HasFactory;

    protected $table = 'edificacoes_locais';

    protected $fillable = [
        'edificacao_nivel_id',
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
