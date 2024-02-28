<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';

    protected $fillable = ['name', 'description', 'unit_price', 'category', 'supplier_id', 'stock', 'image_path' ];

    public function supplier(){
     return $this->belongsTo(Supplier::class);
    }
}
