<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDocumentoExigido extends Model
{
    use HasFactory;

    protected $table = 'clientes_documentos_exigidos';

    protected $fillable = [
        'cliente_id',
        'documento_id'
    ];
}
