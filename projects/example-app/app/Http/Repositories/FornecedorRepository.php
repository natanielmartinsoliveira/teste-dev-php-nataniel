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

    public function search(string $search)
    {
        return $this->fornecedor->search($search);
    }

    public function listAll()
    {
        return $this->fornecedor->paginate(10);
    }

    public function store(Request $request): Fornecedor
    {
        $data = $request->all();
        $data['validade'] = Carbon::parse($data['validade']);
        $model = $this->fornecedor->create($data);
        $model->save();
        return $model;
    }

    public function update(Request $request, int $id) : Fornecedor
    {
        $fornecedor = $this->fornecedor->findOrFail( $id );
        $data = $request->all();
        $data['validade'] = Carbon::parse($data['validade']);
        $fornecedor->update( $data );
        $fornecedor->save();
        return $fornecedor;
    }

    public function delete(int $id) 
    {
        $fornecedor = $this->fornecedor->findOrFail( $id );
        return $fornecedor->delete();
    }
    
  
}
