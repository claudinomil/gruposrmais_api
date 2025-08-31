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
        'tomador_servico_cliente_id',
        'name',
        'nome_profissional',
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
        'carteira_nacional_estado_id',
        'carteira_nacional_orgao_id',
        'carteira_nacional_numero',
        'carteira_nacional_data_emissao',
        'personal_identidade_estado_id',
        'personal_identidade_orgao_id',
        'personal_identidade_numero',
        'personal_identidade_data_emissao',
        'professional_identidade_estado_id',
        'professional_identidade_orgao_id',
        'professional_identidade_numero',
        'professional_identidade_data_emissao',
        'titulo_eleitor_numero',
        'titulo_eleitor_zona',
        'titulo_eleitor_secao',
        'atestado_saude_ocupacional_tipo_id',
        'atestado_saude_ocupacional_data_emissao',
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
        'pix_tipo_id',
        'pix_chave',
        'fotografia_documento',
        'fotografia_cartao_emergencial',
        'fumante',
        'quantidade_cigarros_dia',
        'bebida_alcoolica',
        'bebida_alcoolica_frequencia',
        'historico_familiar_doenca_cardiaca',
        'medicacao_continua',
        'medicacao_continua_qual',
        'hospitalizado',
        'hospitalizado_quando_porque',
        'plano_saude',
        'historico_convulcoes_epilepsia',
        'casos_cancer_familia',
        'casos_cancer_familia_tipos',
        'atividade_fisica',
        'atividade_fisica_frequencia',
        'tipo_sanguineo',
        'fator_rh',
        'contato_1_nome',
        'contato_1_descricao',
        'contato_1_telefone',
        'contato_1_celular',
        'contato_2_nome',
        'contato_2_descricao',
        'contato_2_telefone',
        'contato_2_celular',
        'contato_3_nome',
        'contato_3_descricao',
        'contato_3_telefone',
        'contato_3_celular',
        'contato_4_nome',
        'contato_4_descricao',
        'contato_4_telefone',
        'contato_4_celular',
        'contato_5_nome',
        'contato_5_descricao',
        'contato_5_telefone',
        'contato_5_celular',
        'alergia_1_nome',
        'alergia_1_descricao',
        'alergia_2_nome',
        'alergia_2_descricao',
        'alergia_3_nome',
        'alergia_3_descricao',
        'alergia_4_nome',
        'alergia_4_descricao',
        'alergia_5_nome',
        'alergia_5_descricao',
        'doenca_1_nome',
        'doenca_1_descricao',
        'doenca_2_nome',
        'doenca_2_descricao',
        'doenca_3_nome',
        'doenca_3_descricao',
        'doenca_4_nome',
        'doenca_4_descricao',
        'doenca_5_nome',
        'doenca_5_descricao'
    ];

    protected $dates = [
        'data_nascimento',
        'data_admissao',
        'data_demissao',
        'data_cadastro',
        'data_afastamento',
        'carteira_nacional_data_emissao',
        'personal_identidade_data_emissao',
        'professional_identidade_data_emissao',
        'atestado_saude_ocupacional_data_emissao'
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
    public function setFotografiaDocumentoAttribute($value) {$this->attributes['fotografia_documento'] = mb_strtolower($value);}
    public function setFotografiaCartaoEmergencialAttribute($value) {$this->attributes['fotografia_cartao_emergencial'] = mb_strtolower($value);}

    public function setCarteiraNacionalDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['carteira_nacional_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setPersonalIdentidadeDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['personal_identidade_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setProfessionalIdentidadeDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['professional_identidade_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setAtestadoSaudeOcupacionalDataEmissaoAttribute($value) {if ($value != '') {$this->attributes['atestado_saude_ocupacional_data_emissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataNascimentoAttribute($value) {if ($value != '') {$this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataAdmissaoAttribute($value) {if ($value != '') {$this->attributes['data_admissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataDemissaoAttribute($value) {if ($value != '') {$this->attributes['data_demissao'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataCadastroAttribute($value) {if ($value != '') {$this->attributes['data_cadastro'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}
    public function setDataAfastamentoAttribute($value) {if ($value != '') {$this->attributes['data_afastamento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}

    public function setContato1NomeAttribute($value) {$this->attributes['contato_1_nome'] = mb_strtoupper($value);}
    public function setContato1DescricaoAttribute($value) {$this->attributes['contato_1_descricao'] = mb_strtoupper($value);}
    public function setContato2NomeAttribute($value) {$this->attributes['contato_2_nome'] = mb_strtoupper($value);}
    public function setContato2DescricaoAttribute($value) {$this->attributes['contato_2_descricao'] = mb_strtoupper($value);}
    public function setContato3NomeAttribute($value) {$this->attributes['contato_3_nome'] = mb_strtoupper($value);}
    public function setContato3DescricaoAttribute($value) {$this->attributes['contato_3_descricao'] = mb_strtoupper($value);}
    public function setContato4NomeAttribute($value) {$this->attributes['contato_4_nome'] = mb_strtoupper($value);}
    public function setContato4DescricaoAttribute($value) {$this->attributes['contato_4_descricao'] = mb_strtoupper($value);}
    public function setContato5NomeAttribute($value) {$this->attributes['contato_5_nome'] = mb_strtoupper($value);}
    public function setContato5DescricaoAttribute($value) {$this->attributes['contato_5_descricao'] = mb_strtoupper($value);}
    public function setAlergia1NomeAttribute($value) {$this->attributes['alergia_1_nome'] = mb_strtoupper($value);}
    public function setAlergia1DescricaoAttribute($value) {$this->attributes['alergia_1_descricao'] = mb_strtoupper($value);}
    public function setAlergia2NomeAttribute($value) {$this->attributes['alergia_2_nome'] = mb_strtoupper($value);}
    public function setAlergia2DescricaoAttribute($value) {$this->attributes['alergia_2_descricao'] = mb_strtoupper($value);}
    public function setAlergia3NomeAttribute($value) {$this->attributes['alergia_3_nome'] = mb_strtoupper($value);}
    public function setAlergia3DescricaoAttribute($value) {$this->attributes['alergia_3_descricao'] = mb_strtoupper($value);}
    public function setAlergia4NomeAttribute($value) {$this->attributes['alergia_4_nome'] = mb_strtoupper($value);}
    public function setAlergia4DescricaoAttribute($value) {$this->attributes['alergia_4_descricao'] = mb_strtoupper($value);}
    public function setAlergia5NomeAttribute($value) {$this->attributes['alergia_5_nome'] = mb_strtoupper($value);}
    public function setAlergia5DescricaoAttribute($value) {$this->attributes['alergia_5_descricao'] = mb_strtoupper($value);}
    public function setDoenca1NomeAttribute($value) {$this->attributes['doenca_1_nome'] = mb_strtoupper($value);}
    public function setDoenca1DescricaoAttribute($value) {$this->attributes['doenca_1_descricao'] = mb_strtoupper($value);}
    public function setDoenca2NomeAttribute($value) {$this->attributes['doenca_2_nome'] = mb_strtoupper($value);}
    public function setDoenca2DescricaoAttribute($value) {$this->attributes['doenca_2_descricao'] = mb_strtoupper($value);}
    public function setDoenca3NomeAttribute($value) {$this->attributes['doenca_3_nome'] = mb_strtoupper($value);}
    public function setDoenca3DescricaoAttribute($value) {$this->attributes['doenca_3_descricao'] = mb_strtoupper($value);}
    public function setDoenca4NomeAttribute($value) {$this->attributes['doenca_4_nome'] = mb_strtoupper($value);}
    public function setDoenca4DescricaoAttribute($value) {$this->attributes['doenca_4_descricao'] = mb_strtoupper($value);}
    public function setDoenca5NomeAttribute($value) {$this->attributes['doenca_5_nome'] = mb_strtoupper($value);}
    public function setDoenca5DescricaoAttribute($value) {$this->attributes['doenca_5_descricao'] = mb_strtoupper($value);}
}
