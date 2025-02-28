<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Funcionario extends Model
{
    use HasFactory;

    protected $table = 'funcionarios';

    protected $fillable = [
        'empresa_id',
        'name',
        'data_nascimento',
        'contratacao_tipo_id',
        'genero_id',
        'estado_civil_id',
        'escolaridade_id',
        'nacionalidade_id',
        'naturalidade_id',
        'email',
        'pai',
        'mae',
        'banco_id',
        'agencia',
        'conta',
        'telefone_1',
        'telefone_2',
        'celular_1',
        'celular_2',
        'personal_identidade_estado_id',
        'personal_identidade_orgao_id',
        'personal_identidade_numero',
        'personal_identidade_data_emissao',
        'professional_identidade_estado_id',
        'professional_identidade_orgao_id',
        'professional_identidade_numero',
        'professional_identidade_data_emissao',
        'cpf',
        'pis',
        'pasep',
        'carteira_trabalho',
        'cep',
        'numero',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'departamento_id',
        'funcao_id',
        'data_admissao',
        'data_demissao',
        'data_cadastro',
        'data_afastamento',
        'foto'
    ];

    protected $dates = [
        'data_nascimento',
        'data_admissao',
        'data_demissao',
        'data_cadastro',
        'data_afastamento',
        'personal_identidade_data_emissao',
        'professional_identidade_data_emissao'
    ];

    public function setNameAttribute($value) {$this->attributes['name'] = mb_strtoupper($value);}

    public function setEmailAttribute($value)
    {
        if ($value == '') {
            $this->attributes['email'] = null;
        } else {
            if ($value !== null) {
                $this->attributes['email'] = mb_strtolower($value);
            }
        }
    }
    public function setPaiAttribute($value) {$this->attributes['pai'] = mb_strtoupper($value);}
    public function setMaeAttribute($value) {$this->attributes['mae'] = mb_strtoupper($value);}
    public function setComplementoAttribute($value) {$this->attributes['complemento'] = mb_strtoupper($value);}
    public function setLogradouroAttribute($value) {$this->attributes['logradouro'] = mb_strtoupper($value);}
    public function setBairroAttribute($value) {$this->attributes['bairro'] = mb_strtoupper($value);}
    public function setLocalidadeAttribute($value) {$this->attributes['localidade'] = mb_strtoupper($value);}
    public function setUfAttribute($value) {$this->attributes['uf'] = mb_strtoupper($value);}
    public function setFotoAttribute($value) {$this->attributes['foto'] = mb_strtolower($value);}

    public function setPersonalIdentidadeDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['personal_identidade_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setProfessionalIdentidadeDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['professional_identidade_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataNascimentoAttribute($value) {if ($value != '') {$this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataAdmissaoAttribute($value) {if ($value != '') {$this->attributes['data_admissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataDemissaoAttribute($value) {if ($value != '') {$this->attributes['data_demissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataCadastroAttribute($value) {if ($value != '') {$this->attributes['data_cadastro'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataAfastamentoAttribute($value) {if ($value != '') {$this->attributes['data_afastamento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
}
