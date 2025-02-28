<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'empresa_id',
        'status',
        'tipo',
        'name',
        'nome_fantasia',
        'inscricao_estadual',
        'inscricao_municipal',
        'cpf',
        'cnpj',
        'identidade_estado_id',
        'identidade_orgao_id',
        'identidade_numero',
        'identidade_data_emissao',
        'genero_id',
        'data_nascimento',
        'cep',
        'numero',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'cep_cobranca',
        'numero_cobranca',
        'complemento_cobranca',
        'logradouro_cobranca',
        'bairro_cobranca',
        'localidade_cobranca',
        'uf_cobranca',
        'banco_id',
        'agencia',
        'conta',
        'email',
        'site',
        'telefone_1',
        'telefone_2',
        'celular_1',
        'celular_2'
    ];

    protected $dates = [
        'data_nascimento',
        'identidade_data_emissao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}
    public function setNomeFantasiaAttribute($value) {$this->attributes['nome_fantasia'] = mb_strtoupper($value);}
    public function setComplementoAttribute($value) {$this->attributes['complemento'] = mb_strtoupper($value);}
    public function setLogradouroAttribute($value) {$this->attributes['logradouro'] = mb_strtoupper($value);}
    public function setBairroAttribute($value) {$this->attributes['bairro'] = mb_strtoupper($value);}
    public function setLocalidadeAttribute($value) {$this->attributes['localidade'] = mb_strtoupper($value);}
    public function setUfAttribute($value) {$this->attributes['uf'] = mb_strtoupper($value);}
    public function setComplementoCobrancaAttribute($value) {$this->attributes['complemento_cobranca'] = mb_strtoupper($value);}
    public function setLogradouroCobrancaAttribute($value) {$this->attributes['logradouro_cobranca'] = mb_strtoupper($value);}
    public function setBairroCobrancaAttribute($value) {$this->attributes['bairro_cobranca'] = mb_strtoupper($value);}
    public function setLocalidadeCobrancaAttribute($value) {$this->attributes['localidade_cobranca'] = mb_strtoupper($value);}
    public function setUfCobrancaAttribute($value) {$this->attributes['uf_cobranca'] = mb_strtoupper($value);}
    public function setEmailAttribute($value) {$this->attributes['email'] = mb_strtolower($value);}
    public function setSiteAttribute($value) {$this->attributes['site'] = mb_strtolower($value);}

    public function setIdentidadeDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['identidade_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataNascimentoAttribute($value) {if ($value != '') {$this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
