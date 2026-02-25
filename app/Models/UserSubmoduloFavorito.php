<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubmoduloFavorito extends Model
{
    use HasFactory;

    protected $table = 'users_submodulos_favoritos';

    protected $fillable = [
        'user_id',
        'submodulo_id'
    ];
}
