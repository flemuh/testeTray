<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = (int) $this->route('id');

        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'cpf' => ['required', 'string', 'size:14', 'unique:users,cpf,'.$userId],
            'birth_date' => ['required', 'date', 'before:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter pelo menos 3 caracteres.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.size' => 'O CPF deve estar no formato 000.000.000-00.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'birth_date.required' => 'A data de nascimento é obrigatória.',
            'birth_date.before' => 'A data de nascimento deve ser anterior a hoje.',
        ];
    }
}
