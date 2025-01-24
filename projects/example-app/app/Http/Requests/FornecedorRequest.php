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
        return true;
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
            'cpf' => ['max:11'],
            'cnpj' => ['max:14'],
            'contato' => ['max:255'],
            'logradouro' => [ 'max:255'],
            'bairro' => [ 'max:255'],
            'municipio' => [ 'max:255'],
            'numero' => [ 'max:255'],
            'complemento' => ['max:255'],
            'uf' => [ 'max:255'],
            'cep' => [ 'max:255'],
            
        ];
    }


    
}
