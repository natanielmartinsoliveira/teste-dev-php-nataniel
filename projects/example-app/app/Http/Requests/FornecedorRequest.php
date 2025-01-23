<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FornecedorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {        
        return [
            'nome' => ['required', 'max:255'],
            'documento' => ['required', 'regex:/^(\d{11}|\d{14})$/' ],
            'descricao' => ['nullable', 'max:255'],
            'endereco' => ['nullable', 'max:255']
        ];
    }


    
}
