<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use DateTime;

class ProductResource extends JsonResource
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
            'description' => $this->description,
            'unit_price' => $this->unit_price,
            'category' => $this->category ,
            'supplier_id' => $this->supplier_id,
            'stock' => $this->stock,
            'image' => $this->image_path ? URL::to($this->image_path) : 'http://localhost:8000/images/default.jpg' ,
            'created_at' => ( new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => ( new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
