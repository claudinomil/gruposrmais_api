<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteExecutivoDocumento extends Model
{
    use HasFactory;

    protected $table = 'clientes_executivos_documentos';

    protected $fillable = [
        'cliente_executivo_id',
        'documento_id',
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