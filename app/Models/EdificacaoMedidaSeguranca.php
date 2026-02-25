<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EdificacaoMedidaSeguranca extends Model
{
    use HasFactory;

    protected $table = 'edificacoes_medidas_seguranca';

    protected $fillable = [
        'edificacao_nivel_id',
        'medida_seguranca_id',
        'quantidade'
    ];
}
