<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeiculoCategoria extends Model
{
    use HasFactory;

    protected $table = 'veiculo_categorias';

    protected $fillable = [
        'name'
    ];
}
