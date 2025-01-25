<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Fornecedor;
use Tests\TestCase;
use App\Http\Services\FornecedorService;
use App\Http\Repositories\FornecedorRepository;
use App\Http\Controllers\FornecedorController;
use App\Http\Adapters\CnpjValidatorAdapter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Mockery;


class FornecedorTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware; // use this trait

    protected function setUp(): void
    {
        parent::setUp();

        // Certifique-se de que a configuração de hashing está correta
        \Illuminate\Support\Facades\Hash::setRounds(4);

        $this->fornecedorRepository = new FornecedorRepository(new Fornecedor());
        $this->fornecedorService = new FornecedorService($this->fornecedorRepository);
        $this->fornecedorController = new FornecedorController($this->fornecedorService, Mockery::mock(CnpjValidatorAdapter::class));
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    
    /** @test */
    public function pode_criar_um_fornecedor_via_api()
    {

        $user = \App\Models\User::factory()->create();

        $dados = [
            'nome' => 'Fornecedor Teste',
            'cnpj' => '32922223000100',
            'contato' => '123456789',
            'logradouro' => 'Rua Teste',
            'numero' => '123',
            'complemento' => 'Complemento Teste',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Cidade Teste',
            'uf' => 'SP',
            'cep' => '12345678'

        ];

        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->withHeaders([
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                        ])->postJson('/api/fornecedor', $dados);

        $response->assertStatus(201);
        $this->assertDatabaseHas('fornecedores', ['cnpj' => '32922223000100']);
    }

    /** @test */
    public function pode_atualizar_um_fornecedor_via_api()
    {
        $user = \App\Models\User::factory()->create();
        $fornecedor = Fornecedor::factory()->create();

        $dadosAtualizados = ['nome' => 'Nome Atualizado', 'cnpj' => '32922223000100'];

        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->withHeaders([
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                        ])->putJson("/api/fornecedor/{$fornecedor->id}", $dadosAtualizados);
                         
        $response->assertStatus(200);
        $this->assertDatabaseHas('fornecedores', ['id' => $fornecedor->id, 'nome' => 'Nome Atualizado']);
    }

    /** @test */
    public function pode_excluir_um_fornecedor_via_api()
    {
        $user = \App\Models\User::factory()->create();
        $fornecedor = Fornecedor::factory()->create();

        $token = $user->createToken('Test Token')->plainTextToken;

        $response = $this->withHeaders([
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                         ])->deleteJson("/api/fornecedor/{$fornecedor->id}");
        $response->assertStatus(200);
        $this->assertDatabaseMissing('fornecedores', ['id' => $fornecedor->id]);
    }

    /** @test */
    public function pode_listar_fornecedores_via_api()
    {
        Fornecedor::factory()->count(5)->create();

        $response = $this->getJson('/api/fornecedor');
        $response->assertStatus(200);
        $response->assertJsonCount(5, 'data');
    }

    

}
