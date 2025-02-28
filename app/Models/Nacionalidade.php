<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nacionalidade extends Model
{
    use HasFactory;

    protected $table = 'nacionalidades';

    protected $fillable = [
        'name',
        'nation'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setNationAttribute($value) {$this->attributes['nation'] = mb_strtoupper($value);}
}
