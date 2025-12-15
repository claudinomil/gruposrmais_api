<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EstoqueLocalUpdateRequest extends FormRequest
{
    public function rules()
    {
        $id = $this->route('id') ?? $this->input('id'); // obtém o ID, caso venha pela rota ou request

        return [
            'estoque_id' => ['required'],
            'name' => [
                'required',
                function ($attribute, $value, $fail) use ($id) {
                    $estoqueId = $this->input('estoque_id');
                    $empresaId = $this->input('empresa_id');
                    $clienteId = $this->input('cliente_id');

                    $query = \App\Models\EstoqueLocal::where('name', $value)
                        ->where('estoque_id', $estoqueId);

                    if ($estoqueId == 1) {
                        $query->where('empresa_id', $empresaId);
                    } elseif ($estoqueId == 2) {
                        $query->where('cliente_id', $clienteId);
                    }

                    // Ignora o registro atual se for update
                    if (!empty($id)) {
                        $query->where('id', '<>', $id);
                    }

                    if ($query->exists()) {
                        $fail('Já existe um registro com este nome para o mesmo tipo de estoque e empresa/cliente.');
                    }
                },
            ],
            'empresa_id' => ['required_if:estoque_id,1', 'nullable', 'integer'],
            'cliente_id' => ['required_if:estoque_id,2', 'nullable', 'integer'],
        ];
    }

    public function messages()
    {
        return [
            'estoque_id.required' => 'O campo Estoque é obrigatório.',
            'name.required' => 'O Nome é obrigatório.',
            'empresa_id.required_if' => 'O campo Empresa é obrigatório quando o Estoque for "Empresa".',
            'cliente_id.required_if' => 'O campo Cliente é obrigatório quando o Estoque for "Cliente".',
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
