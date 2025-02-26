<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    use HasFactory;

    protected $table = 'fornecedores';

    protected $fillable = [
        'nome',
        'cnpj',
        'cpf',
        'endereco',
        'contato',
        'logradouro',
        'bairro',
        'municipio',
        'numero',
        'complemento',
        'uf',
        'cep'
    ];

    
}
