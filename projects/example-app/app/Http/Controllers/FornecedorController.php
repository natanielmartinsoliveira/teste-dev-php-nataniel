<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Fornecedor as FornecedorResource;
use App\Http\Services\FornecedorService;
use Illuminate\Support\Facades\Validator;
use App\Http\Adapters\CnpjValidatorAdapter;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\FornecedorRequest;

class FornecedorController extends Controller
{
    private $fornecedorService;
    private $cnpjValidator;

    public function __construct(FornecedorService $fornecedorService, CnpjValidatorAdapter $cnpjValidator)
    {
        $this->fornecedorService = $fornecedorService;
        $this->cnpjValidator = $cnpjValidator;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['nome', 'cnpj', 'cpf']);
        $key = 'fornecedores:' . http_build_query($filters) . ':page:' . $request->get('page', 1);
        if($request->get('nocache') == 'true'){
            Cache::forget($key);
        }
        $fornecedores = Cache::remember($key, 3600, function () use ($filters) {
            return $this->fornecedorService->getAllWithFilters($filters);
        });

        return FornecedorResource::collection($fornecedores);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FornecedorRequest $request)
    {
        
        $validatedData = $this->validateRequest($request);

        if (!empty($validatedData['cnpj'])) {
            $cnpjData = $this->cnpjValidator->validate($validatedData['cnpj']);
            if (!$cnpjData) {
                return response()->json(['message' => 'CNPJ inválido ou não encontrado na base externa.'], 400);
            }

            // Mesclando os dados da API com os do usuário
            $validatedData = array_merge($validatedData, [
                'nome' => $validatedData['nome'] ?? $cnpjData['razao_social'],
                'cep' => $validatedData['cep'] ?? $cnpjData['cep'],
                'logradouro' => $validatedData['logradouro'] ?? $cnpjData['logradouro'],
                'bairro' => $validatedData['bairro'] ?? $cnpjData['bairro'],
                'municipio' => $validatedData['municipio'] ?? $cnpjData['municipio'],
                'uf' => $validatedData['uf'] ?? $cnpjData['uf'],
                'numero' => $validatedData['numero'] ?? $cnpjData['numero'],
                'complemento' => $validatedData['complemento'] ?? $cnpjData['complemento'], 
                'contato' => $validatedData['contato'] ?? $cnpjData['ddd_telefone_1'],
            ]);
        }

        $fornecedor = $this->fornecedorService->create($validatedData);

        return new FornecedorResource($fornecedor);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $fornecedor = $this->fornecedorService->findById($id);
        if (!$fornecedor) {
            return response()->json(['message' => 'Fornecedor não encontrado'], 404);
        }

        return new FornecedorResource($fornecedor);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(FornecedorRequest $request, $id)
    {
        
        $validatedData = $this->validateRequest($request, $id);

        if (!empty($validatedData['cnpj'])) {
            $cnpjData = $this->cnpjValidator->validate($validatedData['cnpj']);
            if (!$cnpjData) {
                return response()->json(['message' => 'CNPJ inválido ou não encontrado na base externa.'], 400);
            }
            
            // Mesclando os dados da API com os do usuário
            $validatedData = array_merge($validatedData, [
                'nome' => $validatedData['nome'] ?? $cnpjData['razao_social'],
                'cep' => $validatedData['cep'] ?? $cnpjData['cep'],
                'logradouro' => $validatedData['logradouro'] ?? $cnpjData['logradouro'],
                'bairro' => $validatedData['bairro'] ?? $cnpjData['bairro'],
                'municipio' => $validatedData['municipio'] ?? $cnpjData['municipio'],
                'uf' => $validatedData['uf'] ?? $cnpjData['uf'],
                'numero' => $validatedData['numero'] ?? $cnpjData['numero'],
                'complemento' => $validatedData['complemento'] ?? $cnpjData['complemento'], 
                'contato' => $validatedData['contato'] ?? $cnpjData['ddd_telefone_1'],
            ]);
        }

        $fornecedor = $this->fornecedorService->update($id, $validatedData);

        return new FornecedorResource($fornecedor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $fornecedor = $this->fornecedorService->delete($id);
        return response()->json(['message' => 'Fornecedor removido com sucesso.']);
    }

    private function validateRequest($request, $id = null)
    {

        $request->merge([
            'cpf' => $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null,
            'cnpj' => $request->cnpj ? preg_replace('/\D/', '', $request->cnpj) : null,
        ]);


        $rules = [
            'nome' => 'required|string|max:255',
            'cnpj' => 'nullable|digits:14|unique:fornecedores,cnpj' . ($id ? "," . $id : ""),
            'cpf' => 'nullable|digits:11|unique:fornecedores,cpf' . ($id ? "," . $id : ""),
            'contato' => 'string',
            'logradouro' => 'string',
            'bairro' => 'string',
            'municipio' => 'string',
            'numero' => 'string',
            'complemento' => 'string',
            'uf	' => 'string',
            'cep' => 'string'
        ];

        $validatedData = $request->validate($rules);

        if (!empty($validatedData['cpf'])) {
            $validatedData['cpf'] = preg_replace('/\D/', '', $validatedData['cpf']);
        }

        if (empty($validatedData['cnpj']) && empty($validatedData['cpf'])) {
            throw new \Illuminate\Validation\ValidationException(validator: null, response: response()->json(['message' => 'É obrigatório informar pelo menos um dos campos: CNPJ ou CPF.'], 400));
        }

        return $validatedData;
    }

    
    
}
