<?php

namespace App\Http\Repositories;


use App\Models\Fornecedor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FornecedorRepository 
{
    /**
     * @var Fornecedor
     */
    protected $fornecedor;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function __construct(Fornecedor $fornecedor)
    {
        return $this->fornecedor = $fornecedor;
    }

    public function find(int $id)
    {
        return $this->fornecedor->find($id);
    }

    public function getAllWithFilters(array $filters)
    {
        $query = $this->fornecedor->query();

        if (!empty($filters['nome'])) {
            $query->where('nome', 'like', '%' . $filters['nome'] . '%');
        }

        if (!empty($filters['cnpj'])) {
            $query->where('cnpj', $filters['cnpj']);
        }

        if (!empty($filters['cpf'])) {
            $query->where('cpf', $filters['cpf']);
        }

        return $query->paginate(10);
    }

    public function search(string $search)
    {
        return $this->fornecedor->search($search);
    }

    public function findById($id)
    {
        return $this->fornecedor->find($id);
    }

    public function create(array $data)
    {
        return $this->fornecedor->create($data);
    }

    public function update($id, array $data)
    {
        $fornecedor = $this->fornecedor->findOrFail($id);
        $fornecedor->update($data);

        return $fornecedor;
    }

    public function delete(int $id) 
    {
        $fornecedor = $this->fornecedor->findOrFail( $id );
        return $fornecedor->delete();
    }
    

    
  
}
