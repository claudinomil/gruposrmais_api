<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ClienteExecutivo extends Model
{
    use HasFactory;

    protected $table = 'clientes_executivos';

    protected $fillable = [
        'cliente_id',
        'executivo_nome',
        'executivo_funcao',
        'nome_profissional',
        'genero_id',
        'data_nascimento',
        'nacionalidade_id',
        'cpf',
        'personal_identidade_estado_id',
        'personal_identidade_orgao_id',
        'personal_identidade_numero',
        'email',
        'telefone_1',
        'telefone_2',
        'celular_1',
        'celular_2',
        'fotografia_documento',
        'fotografia_cartao_emergencial',
        'cep',
        'numero',
        'complemento',
        'logradouro',
        'bairro',
        'localidade',
        'uf',
        'tipo_sanguineo',
        'fator_rh',
        'altura',
        'peso',
        'doenca_diabetes',
        'doenca_hipertensao',
        'doenca_asma',
        'doenca_renal',
        'doenca_cardiaca',
        'doenca_outras',
        'deficiencia_qual',
        'cirurgia_quais_quando',
        'hospitalizado_quando_porque',
        'convulsoes_epilepsia_ultimo_episodio',
        'alergia_medicamentos_alimentos_substancias',
        'medicacao_continua_quais_dosagem_horarios',
        'plano_saude_qual',
        'fumante',
        'bebida_alcoolica',
        'atividade_fisica',
        'doenca_familia_diabetes',
        'doenca_familia_hipertensao',
        'doenca_familia_epilepsia',
        'doenca_familia_cardiaca',
        'doenca_familia_cancer',
        'doenca_familia_outras',
        'contato_1_nome',
        'contato_1_parentesco',
        'contato_1_telefone',
        'contato_1_celular',
        'contato_2_nome',
        'contato_2_parentesco',
        'contato_2_telefone',
        'contato_2_celular'
    ];

    public function setExecutivoNomeAttribute($value) {$this->attributes['executivo_nome'] = mb_strtoupper($value);}
    public function setExecutivoFuncaoAttribute($value) {$this->attributes['executivo_funcao'] = mb_strtoupper($value);}

    public function setFotografiaDocumentoAttribute($value) {$this->attributes['fotografia_documento'] = mb_strtolower($value);}
    public function setFotografiaCartaoEmergencialAttribute($value) {$this->attributes['fotografia_cartao_emergencial'] = mb_strtolower($value);}
    
    public function setDataNascimentoAttribute($value) {if ($value != '') {$this->attributes['data_nascimento'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');}}

    public function setAlturaAttribute($value)
    {
        if ($value != '') {
            $value = str_replace(',', '.', $value);

            $this->attributes['altura'] = $value;
        } else {
            $this->attributes['altura'] = null;
        }
    }

    public function setPesoAttribute($value)
    {
        if ($value != '') {
            $value = str_replace(',', '.', $value);

            $this->attributes['peso'] = $value;
        } else {
            $this->attributes['peso'] = null;
        }
    }

    public function setContato1NomeAttribute($value) {$this->attributes['contato_1_nome'] = mb_strtoupper($value);}
    public function setContato1ParentescoAttribute($value) {$this->attributes['contato_1_parentesco'] = mb_strtoupper($value);}
    public function setContato2NomeAttribute($value) {$this->attributes['contato_2_nome'] = mb_strtoupper($value);}
    public function setContato2ParentescoAttribute($value) {$this->attributes['contato_2_parentesco'] = mb_strtoupper($value);}
}
