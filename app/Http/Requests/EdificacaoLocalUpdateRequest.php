<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EdificacaoLocalUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'edificacao_nivel_id' => ['required', 'integer'],
            'name' => [
                'required',
                Rule::unique('edificacoes_locais')
                    ->ignore($this->route('id')) // ou $this->id dependendo da sua rota
                    ->where(fn ($query) => $query->where('edificacao_nivel_id', $this->edificacao_nivel_id)),
            ],
        ];
    }

    public function messages()
    {
        return [
            'edificacao_nivel_id.required' => 'A Edificação Nível é requerido.',
            'edificacao_nivel_id.integer' => 'A Edificação Nível deve ser um ítem da lista.',
            'name.required' => 'O Nome é requerido.',
            'name.unique' => 'Já existe um registro com este Nome para a mesma Edificação Nível.',
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
