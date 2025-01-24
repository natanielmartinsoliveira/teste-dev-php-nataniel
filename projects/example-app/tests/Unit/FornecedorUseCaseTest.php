<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Fornecedor;
use App\Http\Repositories\FornecedorRepository;
use App\Http\Services\FornecedorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\FornecedorController;
use App\Http\Adapters\CnpjValidatorAdapter;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Mockery;

class FornecedorUseCaseTest extends TestCase
{
    use RefreshDatabase;

    private $fornecedorRepository;
    private $fornecedorService;
    private $fornecedorController;

    protected function setUp(): void
    {
        parent::setUp();

        // Use uma instância real de FornecedorRepository
        $this->fornecedorRepository = new FornecedorRepository(new Fornecedor());
        $this->fornecedorService = new FornecedorService($this->fornecedorRepository);
        $this->fornecedorController = new FornecedorController($this->fornecedorService, Mockery::mock(CnpjValidatorAdapter::class));
    }

    /** @test */
    public function pode_criar_um_fornecedor()
    {
        $dados = [
            'nome' => 'Fornecedor Teste',
            'cnpj' => '12345678901234',
            'contato' => '123456789',
            'logradouro' => 'Rua Teste',
            'numero' => '123',
            'complemento' => 'Complemento Teste',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Cidade Teste',
            'uf' => 'SP',
            'cep' => '12345678'
        ];

        $fornecedor = $this->fornecedorRepository->create($dados);
        $this->assertDatabaseHas('fornecedores', ['cnpj' => '12345678901234']);
    }

    /** @test */
    public function pode_atualizar_um_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();
        $dadosAtualizados = ['nome' => 'Nome Atualizado'];
        $this->fornecedorRepository->update($fornecedor->id, $dadosAtualizados);
        $this->assertDatabaseHas('fornecedores', ['id' => $fornecedor->id, 'nome' => 'Nome Atualizado']);
    }

    /** @test */
    public function pode_excluir_um_fornecedor()
    {
        $fornecedor = Fornecedor::factory()->create();
        $this->fornecedorRepository->delete($fornecedor->id);
        $this->assertDatabaseMissing('fornecedores', ['id' => $fornecedor->id]);
    }

    /** @test */
    public function pode_listar_fornecedores()
    {
        Fornecedor::factory()->count(5)->create();
        
        $fornecedores = $this->fornecedorRepository->getAllWithFilters([]);
        $this->assertEquals(5, $fornecedores->total());
    }
}
