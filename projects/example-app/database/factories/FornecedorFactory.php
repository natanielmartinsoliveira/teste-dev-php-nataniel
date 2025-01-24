<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\fornecedor>
 */
class FornecedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => fake()->name(),
            'cnpj' => Str::random(14),
            'cpf' => Str::random(11),
            'contato' => fake()->phoneNumber(),
            'logradouro' => fake()->streetName(),
            'bairro' => fake()->word(),
            'municipio' => fake()->city(),
            'numero' => fake()->randomNumber(3),
            'complemento' => fake()->word(),
            'uf' => fake()->stateAbbr(),
            'cep' => fake()->postcode()

        ];
    }
}
