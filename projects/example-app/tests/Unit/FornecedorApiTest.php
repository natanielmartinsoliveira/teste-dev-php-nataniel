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
use App\Http\Requests\FornecedorRequest;
use Mockery;

class FornecedorApiTest extends TestCase
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

    public function testIndex()
    {
        $filters = ['nome' => 'Teste'];
        $request = Request::create('/fornecedor', 'GET', $filters);
        $response = $this->fornecedorController->index($request);
        $this->assertInstanceOf(AnonymousResourceCollection::class, $response);
    }

    public function testStore()
    {

        $mockCnpjValidator = Mockery::mock(CnpjValidatorAdapter::class);
        $mockCnpjValidator->shouldReceive('validate')
            ->with('32922223000100') 
            ->once() 
            ->andReturn([
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
                        ]); 

        $fornecedorController2 = new FornecedorController(
            $this->fornecedorService,
            $mockCnpjValidator
        );
        $request = FornecedorRequest::create('/fornecedor', 'POST', [
            'nome' => 'Fornecedor Teste',
            'cnpj' => '32922223000100',
            'contato' => '123456789',
            'logradouro' => 'Rua Teste',
            'numero' => '123',
            'complemento' => 'Complemento Teste',
            'bairro' => 'Bairro Teste',
            'municipio' => 'Cidade Teste',
            'uf' => 'SP',
            'cep' => '12345678',
        ]);

        $response = $fornecedorController2->store($request);
        $this->assertEquals('Fornecedor Teste', $response->resource['nome']);
    }

    public function testShow()
    {
        $fornecedor = Fornecedor::factory()->create(['nome' => 'Teste Fornecedor']);
        $response = $this->fornecedorController->show($fornecedor->id);
        $this->assertEquals('Teste Fornecedor', $response->resource['nome']);
    }

    public function testUpdate()
    {

        $mockCnpjValidator = Mockery::mock(CnpjValidatorAdapter::class);
        $mockCnpjValidator->shouldReceive('validate')
            ->with('32922223000100') 
            ->once() 
            ->andReturn([
                        'nome' => 'Fornecedor Antigo',
                        'cnpj' => '32922223000100',
                        'contato' => '123456789',
                        'logradouro' => 'Rua Teste',
                        'numero' => '123',
                        'complemento' => 'Complemento Teste',
                        'bairro' => 'Bairro Teste',
                        'municipio' => 'Cidade Teste',
                        'uf' => 'SP',
                        'cep' => '12345678',
                        'ddd_telefone_1' => '1132333223'
                        ]); 

        $fornecedorController2 = new FornecedorController(
            $this->fornecedorService,
            $mockCnpjValidator
        );
        $fornecedor = Fornecedor::factory()->create(['nome' => 'Fornecedor Antigo','cnpj' => '32922223000100']);
        $request = FornecedorRequest::create('/fornecedor/' . $fornecedor->id, 'PUT', [
            'nome' => 'Fornecedor Atualizado',
            'cnpj' => '32922223000100'
        ]);

        $response = $fornecedorController2->update($request, $fornecedor->id);
        $this->assertEquals('Fornecedor Atualizado', $response->resource['nome']);
    }

    public function testDestroy()
    {
        $fornecedor = Fornecedor::factory()->create();
        $response = $this->fornecedorController->destroy($fornecedor->id);
        $this->assertEquals(200, $response->status());
    }


}
