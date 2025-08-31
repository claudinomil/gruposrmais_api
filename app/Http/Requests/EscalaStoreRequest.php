<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EscalaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'cliente_id' => ['required'],
            'escala_tipo_id' => ['required'],
            'escala_jornada_id' => ['required']
        ];
    }

    public function messages()
    {
        return [
            'cliente_id.required' => 'Cliente é requerido.',
            'escala_tipo_id.required' => 'Escala Tipo é requerida.',
            'escala_jornada_id.required' => 'Escala Jornada é requerida.'
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
