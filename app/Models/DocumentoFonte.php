<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoFonte extends Model
{
    use HasFactory;

    protected $table = 'documento_fontes';

    protected $fillable = [
        'name',
        'ordem'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
