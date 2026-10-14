<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioDocumentoExigido extends Model
{
    use HasFactory;

    protected $table = 'funcionarios_documentos_exigidos';

    protected $fillable = [
        'funcionario_id',
        'documento_id'
    ];
}
