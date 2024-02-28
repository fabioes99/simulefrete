<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = ['name', 'phone', 'email', 'cep', 'complemento', 'bairro', 'localidade', 'uf'];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
