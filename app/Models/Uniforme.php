<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Uniforme extends Model
{
    use HasFactory;

    protected $table = 'uniformes';

    protected $fillable = [
        'name',
        'funcionarios_campo'
    ];

    public function setNameAttribute(string $value) {$this->attributes['name'] = mb_strtoupper($value);}
}
