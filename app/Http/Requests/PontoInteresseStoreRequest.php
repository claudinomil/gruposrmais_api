<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PontoInteresseStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ponto_tipo_id' => ['required'],
            'name' => ['required'],
            'latitude' => ['required'],
            'longitude' => ['required'],
            'icone' => ['required'],
            'telefone_1' => ['nullable', 'numeric', 'digits:10'],
            'telefone_2' => ['nullable', 'numeric', 'digits:10']
        ];
    }

    public function messages()
    {
        return [
            'ponto_tipo_id.required' => 'O Ponto Tipo é requerido.',
            'name.required' => 'O Nome é requerido.',
            'latitude.required' => 'A Latitude é requerido.',
            'longitude.required' => 'A Longitude é requerido.',
            'icone.required' => 'O Ícone é requerido.',
            'telefone_1.numeric' => 'O Telefone 1 deve ser um número válido.',
            'telefone_1.digits' => 'O Telefone 1 deve ser um número válido.',
            'telefone_2.numeric' => 'O Telefone 2 deve ser um número válido.',
            'telefone_2.digits' => 'O Telefone 2 deve ser um número válido.'
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
