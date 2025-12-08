<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ClienteMaterial extends Model
{
    use HasFactory;

    protected $table = 'clientes_materiais';

    protected $fillable = [
        'cliente_id',
        'cliente_local_id',
        'material_id',
        'quantidade',
        'data_entrada'
    ];

    protected $dates = [
        'data_entrada'
    ];

    public function setDataEntradaAttribute($value) {if ($value != '') {$this->attributes['data_entrada'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}

    public function setQuantidadeAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['quantidade'] = $value;
        } else {
            $this->attributes['quantidade'] = 0;
        }
    }
}
