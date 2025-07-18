<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionarioStoreRequest extends FormRequest
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
            'tomador_servico_cliente_id' => ['nullable', 'integer', 'numeric'],
            'name' => ['required', 'min:3'],
            'nome_profissional' => ['required', 'min:3'],
            'data_nascimento' => ['required', 'date_format:d/m/Y'],
            'contratacao_tipo_id' => ['required', 'integer', 'numeric'],
            'genero_id' => ['required', 'integer', 'numeric'],
            'estado_civil_id' => ['nullable', 'integer', 'numeric'],
            'escolaridade_id' => ['nullable', 'integer', 'numeric'],
            'nacionalidade_id' => ['nullable', 'integer', 'numeric'],
            'naturalidade_id' => ['nullable', 'integer', 'numeric'],
            'pai' => ['nullable', 'min:3'],
            'mae' => ['nullable', 'min:3'],
            'banco_id' => ['nullable', 'integer', 'numeric'],
            'agencia' => ['nullable', 'numeric', 'min:2'],
            'conta' => ['nullable', 'numeric', 'min:3'],
            'email' => ['nullable', 'unique:funcionarios', 'email'],
            'telefone_1' => ['nullable', 'numeric', 'digits:10'],
            'telefone_2' => ['nullable', 'numeric', 'digits:10'],
            'celular_1' => ['nullable', 'numeric', 'digits:11'],
            'celular_2' => ['nullable', 'numeric', 'digits:11'],
            'departamento_id' => ['nullable', 'integer', 'numeric'],
            'funcao_id' => ['nullable', 'integer', 'numeric'],
            'data_admissao' => ['nullable', 'date_format:d/m/Y'],
            'data_demissao' => ['nullable', 'date_format:d/m/Y'],
            'data_cadastro' => ['nullable', 'date_format:d/m/Y'],
            'data_afastamento' => ['nullable', 'date_format:d/m/Y'],
            'personal_identidade_orgao_id' => ['nullable', 'integer', 'numeric'],
            'personal_identidade_estado_id' => ['nullable', 'integer', 'numeric'],
            'personal_identidade_numero' => ['nullable', 'numeric'],
            'personal_identidade_data_emissao' => ['nullable', 'date_format:d/m/Y'],
            'professional_identidade_orgao_id' => ['nullable', 'integer', 'numeric'],
            'professional_identidade_estado_id' => ['nullable', 'integer', 'numeric'],
            'professional_identidade_numero' => ['nullable', 'numeric'],
            'professional_identidade_data_emissao' => ['nullable', 'date_format:d/m/Y'],
            'cpf' => ['required', 'unique:funcionarios', 'cpf'],
            'pis' => ['nullable', 'unique:funcionarios', 'nis'],
            'pasep' => ['nullable', 'unique:funcionarios', 'nis'],
            'carteira_trabalho' => ['nullable', 'unique:funcionarios', 'numeric'],
            'cep' => ['nullable', 'digits:8'],
            'numero' => ['nullable', 'numeric'],
            'complemento' => ['nullable', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            'tomador_servico_cliente_id.integer' => 'O Tomador de Serviço deve ser um ítem da lista.',
            'name.required' => 'O Nome é requerido.',
            'name.min' => 'O Nome deve ter pelo menos 3 caracteres.',
            'nome_profissional.required' => 'O Nome Profissional é requerido.',
            'nome_profissional.min' => 'O Nome Profissional deve ter pelo menos 3 caracteres.',
            'data_nascimento.required' => 'O Nascimento é requerido.',
            'data_nascimento.date_format' => 'O Nascimento não é uma data válida.',
            'contratacao_tipo_id.required' => 'O Tipo de Contratação é requerido.',
            'contratacao_tipo_id.integer' => 'O Tipo de Contratação deve ser um ítem da lista.',
            'genero_id.required' => 'O Gênero é requerido.',
            'genero_id.integer' => 'O Gênero deve ser um ítem da lista.',
            'estado_civil_id.integer' => 'O Estado Civil deve ser um ítem da lista.',
            'escolaridade_id.integer' => 'A Escolaridade deve ser um ítem da lista.',
            'nacionalidade_id.integer' => 'A Nacionalidade deve ser um ítem da lista.',
            'naturalidade_id.integer' => 'A Naturalidade deve ser um ítem da lista.',
            'pai.min' => 'O Pai deve ter pelo menos 3 caracteres.',
            'mae.min' => 'A Mãe deve ter pelo menos 3 caracteres.',
            'banco_id.integer' => 'O Banco deve ser um ítem da lista.',
            'agencia.numeric' => 'A Agência deve ser um número.',
            'agencia.min' => 'A Agência deve ter pelo menos 2 caracteres.',
            'conta.numeric' => 'A Conta deve ser um número.',
            'conta.min' => 'A Conta deve ter pelo menos 3 caracteres.',
            'email.unique' => 'O E-mail já existe.',
            'email.email' => 'O E-mail deve ser um endereço válido.',
            'telefone_1.numeric' => 'O Telefone 1 deve ser um número válido.',
            'telefone_1.digits' => 'O Telefone 1 deve ser um número válido.',
            'telefone_2.numeric' => 'O Telefone 2 deve ser um número válido.',
            'telefone_2.digits' => 'O Telefone 2 deve ser um número válido.',
            'celular_1.numeric' => 'O Celular 1 deve ser um número válido.',
            'celular_1.digits' => 'O Celular 1 deve ser um número válido.',
            'celular_2.numeric' => 'O Celular 2 deve ser um número válido.',
            'celular_2.digits' => 'O Celular 2 deve ser um número válido.',
            'departamento_id.integer' => 'O Departamento deve ser um ítem da lista.',
            'funcao_id.integer' => 'A Função deve ser um ítem da lista.',
            'data_admissao.date_format' => 'A Data Admissão não é uma data válida.',
            'data_demissao.date_format' => 'A Data Demissão não é uma data válida.',
            'data_cadastro.date_format' => 'A Data Cadastro não é uma data válida.',
            'data_afastamento.date_format' => 'A Data Afastamento não é uma data válida.',
            'personal_identidade_orgao_id.integer' => 'A Identidade Pessoal (Òrgão) deve ser um ítem da lista.',
            'personal_identidade_estado_id.integer' => 'A Identidade Pessoal (Estado) deve ser um ítem da lista.',
            'personal_identidade_numero.numeric' => 'A Identidade Pessoal (Número) deve ser um número válido.',
            'personal_identidade_data_emissao.date_format' => 'A Identidade Pessoal (Emissão) não é uma data válida.',
            'professional_identidade_orgao_id.integer' => 'A Identidade Profissional (Òrgão) deve ser um ítem da lista.',
            'professional_identidade_estado_id.integer' => 'A Identidade Profissional (Estado) deve ser um ítem da lista.',
            'professional_identidade_numero.numeric' => 'A Identidade Profissional (Número) deve ser um número válido.',
            'professional_identidade_data_emissao.date_format' => 'A Identidade Profissional (Emissão) não é uma data válida.',
            'cpf.required' => 'O CPF é requerido.',
            'cpf.unique' => 'O CPF já existe.',
            'cpf.cpf' => 'O CPF não é um número válido.',
            'pis.unique' => 'O PIS já existe.',
            'pis.nis' => 'O PIS não é um número válido.',
            'pasep.unique' => 'O PASEP já existe.',
            'pasep.nis' => 'O PASEP não é um número válido.',
            'carteira_trabalho.unique' => 'O Carteira de Trabalho já existe.',
            'carteira_trabalho.numeric' => 'A Carteira de Trabalho não é um número válido.',
            'cep.digits' => 'O CEP deve ter 8 dígitos.',
            'numero.numeric' => 'O Número deve ser um número.',
            'complemento.min' => 'O Complemento deve ter pelo menos 1 caractere.'
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
