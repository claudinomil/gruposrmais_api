<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $table = 'grupos';

    protected $fillable = [
        'empresa_id',
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
