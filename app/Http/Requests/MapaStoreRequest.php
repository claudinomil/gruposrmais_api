<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MapaStoreRequest extends FormRequest
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
            'icone' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'ponto_tipo_id.required' => 'O Ponto Tipo é requerido.',
            'name.required' => 'O Nome é requerido.',
            'latitude.required' => 'A Latitude é requerido.',
            'longitude.required' => 'A Longitude é requerido.',
            'icone.required' => 'O Ícone é requerido.'
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
