<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    use HasFactory;

    protected $table = 'estados';

    protected $fillable = [
        'name',
        'uf'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setUfAttribute($value) {$this->attributes['uf'] = mb_strtoupper($value);}
}
