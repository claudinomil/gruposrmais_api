<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MapaPreventivoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'edificacao_local_id' => ['required', 'integer'],
            'sistema_preventivo_id' => ['required', 'integer']
        ];
    }

    public function messages()
    {
        return [
            'edificacao_local_id.required' => 'Edificação Local é requerido.',
            'edificacao_local_id.integer' => 'Edificação Local deve ser um ítem da lista.',
            'sistema_preventivo_id.required' => 'Sistema Preventivo é requerido.',
            'sistema_preventivo_id.integer' => 'Sistema Preventivo deve ser um ítem da lista.'
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
