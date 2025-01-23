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
            'documento' => $this->documento,
            'contato' => $this->contato,
            'endereco' => $this->endereco,
        ];
    }

}
