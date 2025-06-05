<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteDocumento extends Model
{
    use HasFactory;

    protected $table = 'clientes_documentos';

    protected $fillable = [
        'cliente_id',
        'name',
        'documento',
        'descricao',
        'caminho',
        'data_documento',
        'aviso'
    ];

    protected $dates = [
        'data_documento'
    ];

    public function setDataDocumentoAttribute($value)
    {
        if ($value != '') {
            $this->attributes['data_documento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }
}
