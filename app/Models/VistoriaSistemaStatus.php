<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VistoriaSistemaStatus extends Model
{
    use HasFactory;

    protected $table = 'vistoria_sistema_status';

    protected $fillable = [
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
