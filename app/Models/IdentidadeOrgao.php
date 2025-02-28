<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentidadeOrgao extends Model
{
    use HasFactory;

    protected $table = 'identidade_orgaos';

    protected $fillable = [
        'name',
        'sigla'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setSiglaAttribute($value) {$this->attributes['sigla'] = mb_strtoupper($value);}
}
