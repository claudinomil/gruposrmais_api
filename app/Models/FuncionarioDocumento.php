<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionarioDocumento extends Model
{
    use HasFactory;

    protected $table = 'funcionarios_documentos';

    protected $fillable = [
        'funcionario_id',
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
