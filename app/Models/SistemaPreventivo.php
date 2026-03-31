<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaPreventivo extends Model
{
    use HasFactory;

    protected $table = 'sistemas_preventivos';

    protected $fillable = [
        'medida_seguranca_id',
        'name'
    ];

    public function setPlacaAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
