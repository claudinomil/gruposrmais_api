<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VisitaTecnicaStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //'visita_tecnica_tipo_id' => ['required'],
            //'cliente_id' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            //'visita_tecnica_tipo_id.required' => 'O Tipo é requerido.',
            //'cliente_id.required' => 'O Cliente é requerido.',
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
