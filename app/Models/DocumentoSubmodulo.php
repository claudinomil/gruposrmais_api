<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoSubmodulo extends Model
{
    use HasFactory;

    protected $table = 'documento_submodulos';

    protected $fillable = [
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
