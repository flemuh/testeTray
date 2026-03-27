<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'min:3', 'max:255'],
            'cpf' => ['nullable', 'string', 'size:14'], // 000.000.000-00
            'page' => ['nullable', 'integer', 'min:1'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'cpf.size' => 'CPF inválido.',
            'page.integer' => 'Página deve ser número.',
            'per_page.max' => 'Máximo de 100 registros por página.',
        ];
    }
}
