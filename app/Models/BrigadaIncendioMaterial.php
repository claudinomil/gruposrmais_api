<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaIncendioMaterial extends Model
{
    use HasFactory;

    protected $table = 'brigadas_incendios_materiais';

    protected $fillable = [
        'brigada_incendio_id',
        'material_id',
        'material_categoria_name',
        'material_name',
        'material_quantidade'
    ];

    protected $dates = [];
}