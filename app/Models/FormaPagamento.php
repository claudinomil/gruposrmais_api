<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormaPagamento extends Model
{
    use HasFactory;

    protected $table = 'formas_pagamentos';

    protected $fillable = [
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
