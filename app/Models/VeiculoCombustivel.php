<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VeiculoCombustivel extends Model
{
    use HasFactory;

    protected $table = 'veiculo_combustiveis';

    protected $fillable = [
        'name'
    ];
}
