<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ferramenta extends Model
{
    use HasFactory;

    protected $table = 'ferramentas';

    protected $fillable = [
        'empresa_id',
        'name',
        'descricao',
        'url',
        'icon',
        'viewing_order',
        'user_id'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setUrlAttribute($value) {$this->attributes['url'] = mb_strtoupper($value);}
    public function setIconAttribute($value) {$this->attributes['icon'] = mb_strtoupper($value);}
}
