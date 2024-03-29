<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use DateTime;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name ,
            'phone' => $this->phone,
            'email' => $this->email,
            'cep' => $this->cep ,
            'complemento' => $this->complemento,
            'bairro' => $this->bairro,
            'localidade' => $this->localidade,
            'uf' => $this->uf,
            'created_at' => ( new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => ( new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
