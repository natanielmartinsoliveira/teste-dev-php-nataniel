<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Fornecedor extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray($request){

        return [
            'id' => $this->id,
            'nome' => $this->nome,
            'cpf' => $this->cpf,
            'cnpj' => $this->cnpj,
            'contato' => $this->contato,
            'logradouro' => $this->logradouro,
            'bairro' => $this->bairro,
            'municipio' => $this->municipio,
            'numero' => $this->numero,
            'complemento' => $this->complemento,
            'uf' => $this->uf,
            'cep' => $this->cep,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
            
        ];
    }

}
