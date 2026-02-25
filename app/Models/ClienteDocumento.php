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
        'documento_id',
        'caminho',
        'descricao',
        'data_emissao',
        'data_vencimento',
        'data_ultimo_aviso',
        'aviso'
    ];

    protected $dates = [
        'data_emissao',
        'data_vencimento',
        'data_ultimo_aviso'
    ];

    public function setDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataVencimentoAttribute($value) {if ($value != '') {$this->attributes['data_vencimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataUltimoAvisoAttribute($value) {if ($value != '') {$this->attributes['data_ultimo_aviso'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
