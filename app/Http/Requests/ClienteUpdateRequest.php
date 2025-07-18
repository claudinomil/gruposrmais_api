<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'principal_cliente_id' => ['nullable', 'integer', 'numeric'],
            'rede_cliente_id' => ['nullable', 'integer', 'numeric'],
            'status' => ['required'],
            'tipo' => ['required'],
            'name' => ['required', 'min:3'],
            'nome_fantasia' => ['nullable', 'min:3'],
            'inscricao_estadual' => [
                'nullable',
                Rule::unique('clientes')->ignore($this->id)
            ],
            'inscricao_municipal' => [
                'nullable',
                Rule::unique('clientes')->ignore($this->id)
            ],
            'cpf' => [
                'nullable',
                Rule::unique('clientes')->ignore($this->id),
                'cpf'
            ],
            'cnpj' => [
                'nullable',
                Rule::unique('clientes')->ignore($this->id),
                'cnpj'
            ],
            'identidade_estado_id' => ['nullable', 'integer', 'numeric'],
            'identidade_orgao_id' => ['nullable', 'integer', 'numeric'],
            'personal_identidade_numero' => ['nullable', 'numeric'],
            'identidade_data_emissao' => ['nullable', 'date_format:d/m/Y'],
            'genero_id' => ['nullable', 'integer', 'numeric'],
            'data_nascimento' => ['nullable', 'date_format:d/m/Y'],
            'cep' => ['nullable', 'digits:8'],
            'numero' => ['nullable', 'numeric'],
            'complemento' => ['nullable', 'min:1'],
            'cep_cobranca' => ['nullable', 'digits:8'],
            'numero_cobranca' => ['nullable', 'numeric'],
            'complemento_cobranca' => ['nullable', 'min:1'],
            'banco_id' => ['nullable', 'integer', 'numeric'],
            'agencia' => ['nullable', 'numeric', 'min:2'],
            'conta' => ['nullable', 'numeric', 'min:3'],
            'email' => ['nullable', 'email'],
            'site' => [
                'nullable',
                Rule::unique('clientes')->ignore($this->id),
                'url'
            ],
            'telefone_1' => ['nullable', 'numeric', 'digits:10'],
            'telefone_2' => ['nullable', 'numeric', 'digits:10'],
            'celular_1' => ['nullable', 'numeric', 'digits:11'],
            'celular_2' => ['nullable', 'numeric', 'digits:11'],
        ];
    }

    public function messages()
    {
        return [
            'principal_cliente_id.integer' => 'O Cliente Principal deve ser um ítem da lista.',
            'rede_cliente_id.integer' => 'O Cliente Rede deve ser um ítem da lista.',
            'status.required' => 'O Status é requerido.',
            'tipo.required' => 'O Tipo é requerido.',
            'name.required' => 'O Nome é requerido.',
            'name.min' => 'O Nome deve ter pelo menos 3 caracteres.',
            'nome_fantasia.min' => 'O Nome Fantasia deve ter pelo menos 3 caracteres.',
            'inscricao_estadual.unique' => 'A Inscrição Estadual já existe.',
            'inscricao_estadual.inscricao_estadual' => 'A Inscrição Estadual não é um número válido.',
            'inscricao_municipal.unique' => 'A Inscrição Municipal já existe.',
            'inscricao_municipal.inscricao_municipal' => 'A Inscrição Municipal não é um número válido.',
            'cpf.unique' => 'O CPF já existe.',
            'cpf.cpf' => 'O CPF não é um número válido.',
            'cnpj.unique' => 'O CNPJ já existe.',
            'cnpj.cnpj' => 'O CNPJ não é um número válido.',
            'identidade_orgao_id.integer' => 'A Identidade (Òrgão) deve ser um ítem da lista.',
            'identidade_estado_id.integer' => 'A Identidade (Estado) deve ser um ítem da lista.',
            'identidade_numero.numeric' => 'A Identidade (Número) deve ser um número válido.',
            'identidade_data_emissao.date_format' => 'A Identidade (Emissão) não é uma data válida.',
            'genero_id.integer' => 'O Gênero deve ser um ítem da lista.',
            'data_nascimento.date_format' => 'O Nascimento não é uma data válida.',
            'cep.digits' => 'O CEP deve ter 8 dígitos.',
            'numero.numeric' => 'O Número deve ser um número.',
            'complemento.min' => 'O Complemento deve ter pelo menos 1 caractere.',
            'cep_cobranca.digits' => 'O CEP Cobrança deve ter 8 dígitos.',
            'numero_cobranca.numeric' => 'O Número Cobrança deve ser um número.',
            'complemento_cobranca.min' => 'O Complemento Cobrança deve ter pelo menos 1 caractere.',
            'banco_id.integer' => 'O Banco deve ser um ítem da lista.',
            'agencia.numeric' => 'A Agência deve ser um número.',
            'agencia.min' => 'A Agência deve ter pelo menos 2 caracteres.',
            'conta.numeric' => 'A Conta deve ser um número.',
            'conta.min' => 'A Conta deve ter pelo menos 3 caracteres.',
            'email.email' => 'O E-mail deve ser um endereço válido.',
            'site.unique' => 'O Site já existe.',
            'site.site' => 'O Site deve ser um endereço válido.',
            'telefone_1.numeric' => 'O Telefone 1 deve ser um número válido.',
            'telefone_1.digits' => 'O Telefone 1 deve ser um número válido.',
            'telefone_2.numeric' => 'O Telefone 2 deve ser um número válido.',
            'telefone_2.digits' => 'O Telefone 2 deve ser um número válido.',
            'celular_1.numeric' => 'O Celular 1 deve ser um número válido.',
            'celular_1.digits' => 'O Celular 1 deve ser um número válido.',
            'celular_2.numeric' => 'O Celular 2 deve ser um número válido.',
            'celular_2.digits' => 'O Celular 2 deve ser um número válido.',
        ];
    }

    // Se precisar customizar a resposta JSON (para API requests)
    public function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        throw new \Illuminate\Validation\ValidationException($validator, response()->json([
            'message' => 'Erro de validação',
            'code' => 2020,
            'validation' => $validator->errors(),
            'content' => []
        ], 200));
    }
}
