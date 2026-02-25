<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedidaSeguranca extends Model
{
    use HasFactory;

    protected $table = 'medidas_seguranca';

    protected $fillable = [
        'name',
        'ordem'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
