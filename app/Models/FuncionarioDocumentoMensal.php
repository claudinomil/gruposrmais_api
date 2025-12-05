<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioDocumentoMensal extends Model
{
    use HasFactory;

    protected $table = 'funcionarios_documentos_mensais';

    protected $fillable = [
        'funcionario_id',
        'documento_mensal_funcionario_id',
        'mes',
        'ano',
        'caminho'
    ];
}
