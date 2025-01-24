<?php

namespace App\Http\Services;

use App\Http\Repositories\FornecedorRepository;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

Interface FornecedorServiceInterface
{

    public function __construct(FornecedorRepository $postRepositories);

    public function getAllWithFilters(array $filters);

    public function create(array $data) : Fornecedor;

    public function findById($id) ;

    public function update($id, array $data) : Fornecedor;

    public function delete(int $id);

    
  
}
