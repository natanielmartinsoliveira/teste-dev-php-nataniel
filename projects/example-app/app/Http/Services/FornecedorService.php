<?php

namespace App\Http\Services;

use App\Http\Repositories\FornecedorRepository;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorService implements FornecedorServiceInterface
{
    private $fornecedorRepository;

    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    public function getAllWithFilters(array $filters)
    {
        return $this->fornecedorRepository->getAllWithFilters($filters);
    }

    public function create(array $data) : Fornecedor
    {
        return $this->fornecedorRepository->create($data);
    }

    public function findById($id) 
    {
        return $this->fornecedorRepository->findById($id);
    }

    public function update($id, array $data) : Fornecedor
    {
        return $this->fornecedorRepository->update($id, $data);
    }

    public function delete($id)
    {
        $this->fornecedorRepository->delete($id);
    }

  
}
