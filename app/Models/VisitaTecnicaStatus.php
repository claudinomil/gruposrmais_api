<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaTecnicaStatus extends Model
{
    use HasFactory;

    protected $table = 'visita_tecnica_status';

    protected $fillable = [
        'name'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
}
