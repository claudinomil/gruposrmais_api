<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SistemaPreventivoStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'medida_seguranca_id' => ['required', 'integer'],
            'name' => [
                'required',
                Rule::unique('sistemas_preventivos')->where(function ($query) {
                    return $query->where('medida_seguranca_id', $this->medida_seguranca_id);
                }),
            ],
        ];
    }

    public function messages()
    {
        return [
            'medida_seguranca_id.required' => 'A Medida Segurança é requerido.',
            'medida_seguranca_id.integer' => 'A Medida Segurança deve ser um ítem da lista.',
            'name.required' => 'O Nome é requerido.',
            'name.unique' => 'Já existe um registro com este Nome para a mesma Medida Segurança.',
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
