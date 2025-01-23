<?php

namespace App\Http\Services;

use App\Http\Repositories\FornecedorRepository;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorService implements FornecedorServiceInterface
{
    /**
     * @var $postRepositories
     */
    protected $postRepositories;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function __construct(FornecedorRepository $postRepositories)
    {
        $this->postRepositories = $postRepositories;
    }

    public function find(int $id)
    {
        return $this->postRepositories->find($id);
    }

    public function search(string $search)
    {
        return $this->postRepositories->search($search);
    }

    public function listAll()
    {
        return $this->postRepositories->listAll();
    }

    public function store(Request $request): Fornecedor
    {
        return $this->postRepositories->store($request);
    }

    public function update(Request $request,int $id) : Fornecedor 
    {
        return $this->postRepositories->update( $request, $id );
    }

    public function delete(int $id) 
    {
        return $this->postRepositories->delete($id);
    }

    public function upload(Request $request)
    {
        return $this->postRepositories->upload($request);
    }

  
}
