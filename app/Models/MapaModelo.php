<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MapaModelo extends Model
{
    use HasFactory;

    protected $table = 'mapas_modelos';

    protected $fillable = [
        'name'
    ];


    protected $dates = [];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
