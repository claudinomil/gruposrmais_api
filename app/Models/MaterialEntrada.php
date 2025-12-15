<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class MaterialEntrada extends Model
{
    use HasFactory;

    protected $table = 'materiais_entradas';

    protected $fillable = [
        'empresa_id',
        'fornecedor_id',
        'nf_numero',
        'nf_serie',
        'nf_chave_acesso',
        'data_emissao',
        'valor_total',
        'valor_desconto',
        'fornecedor_nome',
        'fornecedor_cnpj',
        'fornecedor_email',
        'fornecedor_telefone',
        'fornecedor_celular',
        'fornecedor_logradouro',
        'fornecedor_bairro',
        'fornecedor_logradouro_numero',
        'fornecedor_logradouro_complemento',
        'fornecedor_cidade',
        'fornecedor_uf',
        'nf_pdf_caminho',
        'estoque_local_id'
    ];

    protected $dates = [
        'data_emissao'
    ];

    public function setDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}

    public function setValorTotalAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['valor_total'] = $value;
        } else {
            $this->attributes['valor_total'] = 0;
        }
    }

    public function setValorDescontoAttribute($value)
    {
        if ($value != '') {
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace('.', '', $value);
            $value = str_replace(',', '.', $value);

            $this->attributes['valor_desconto'] = $value;
        } else {
            $this->attributes['valor_desconto'] = 0;
        }
    }
}
