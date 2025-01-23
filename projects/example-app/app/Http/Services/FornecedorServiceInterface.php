<?php

namespace App\Http\Services;

use App\Http\Repositories\FornecedorRepository;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

Interface FornecedorServiceInterface
{

    public function __construct(FornecedorRepository $postRepositories);

    public function find(int $id);

    public function search(string $search);

    public function listAll();

    public function store(Request $fornecedor): Fornecedor;

    public function update(Request $fornecedor, int $id) : Fornecedor;

    public function delete(int $id) ;

    public function upload(Request $request) ;
  
}
