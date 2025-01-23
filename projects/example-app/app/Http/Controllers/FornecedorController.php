<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Fornecedor as FornecedorResource;
use App\Http\Services\FornecedorService;
use Illuminate\Support\Facades\Validator;

class FornecedorController extends Controller
{
    private $service;

    public function __construct(FornecedorService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornecedor = $this->service->listAll();
        return FornecedorResource::collection($fornecedor);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|unique:fornecedores|regex:/^(\d{11}|\d{14})$/',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string|max:255',
        ]);
        if($validator->fails()) return response()->json(array(
            'code'      =>  401,
            'message'   =>  'Error'
        ), 401); 
        $fornecedor = $this->service->store($request);
        return new FornecedorResource($fornecedor);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $fornecedor = $this->service->find($id);
        return new FornecedorResource( $fornecedor );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
 
        $data =  $request->all();
        $validator = Validator::make($data, [
            'nome' => 'required|string|max:255',
            'documento' => 'required|string|unique:fornecedores|regex:/^(\d{11}|\d{14})$/',
            'contato' => 'nullable|string|max:255',
            'endereco' => 'nullable|string|max:255',
        ]);
        if($validator->fails()) return response()->json(array(
            'code'      =>  401,
            'message'   =>  'Error'
        ), 401); 
        $fornecedor = $this->service->update($request, $id);
        return new FornecedorResource( $fornecedor );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fornecedor = $this->service->delete($id);
        if( !$fornecedor ){
            return new FornecedorResource( $fornecedor );
        }
    }

    
    
}
