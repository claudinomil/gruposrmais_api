<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrigadaIncendioProduto extends Model
{
    use HasFactory;

    protected $table = 'brigadas_incendios_produtos';

    protected $fillable = [
        'brigada_incendio_id',
        'produto_id',
        'produto_categoria_name',
        'produto_name',
        'produto_quantidade'
    ];

    protected $dates = [];
}
