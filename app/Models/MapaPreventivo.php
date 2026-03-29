<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapaPreventivo extends Model
{
    use HasFactory;

    protected $table = 'mapas_preventivos';

    protected $fillable = [
        'edificacao_local_id'
    ];
}
