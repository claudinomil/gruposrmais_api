<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeiculoModelo extends Model
{
    use HasFactory;

    protected $table = 'veiculo_modelos';

    protected $fillable = [
        'name',
        'veiculo_marca_id'
    ];
}
