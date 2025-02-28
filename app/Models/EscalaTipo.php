<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscalaTipo extends Model
{
    use HasFactory;

    protected $table = 'escala_tipos';

    protected $fillable = [
        'name',
        'quantidade_alas',
        'quantidade_horas'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
