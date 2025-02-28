<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConfiguracao extends Model
{
    use HasFactory;

    protected $table = 'users_configuracoes';

    protected $fillable = [
        'user_id',
        'empresa_id',
        'grupo_id',
        'situacao_id',
        'sistema_acesso_id',
        'layout_mode',
        'layout_style',
    ];
}
