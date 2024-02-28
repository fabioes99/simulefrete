<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = Product::all();
        return ProductResource::collection($product);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'unit_price' => 'required|numeric',
            'category' => 'required|string',
            'supplier_id' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        if(isset($data['image'])){
            $relativePath = $this->saveImage($data['image']);
            $data['image_path'] = $relativePath;
        }

        $product = Product::create($data);

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request , $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'unit_price' => 'required|numeric',
            'category' => 'required|string',
            'supplier_id' => 'required|integer',
            'stock' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $product = Product::find($id);

        if(isset($data['image'])){

            $relativePath = $this->saveImage($data['image']);
            $data['image_path'] = $relativePath;

            //if ther is an old image delete
            if($product->image_path){
                $absolutePath = public_path($product->image_path);
                File::delete($absolutePath);
            }
        }

        return $product->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        return $product->delete();
    }

    private function saveImage($image){

        if(preg_match('/^data:image\/(\w+);base64,/', $image, $type)){
            $image = substr($image, strpos($image, ',') + 1);

            $type = strtolower($type[1]);

            if(!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])){
                throw new \Exception('Tipo de imagem iválido');
            }

            $image = str_replace('','+',$image);
            $image = base64_decode($image);

            if($image === false){
                throw new \Exception('base_64_decode failed');
            }
        } else {
            throw new \Exception('Não foi possivel carregar a imagem');
        }

        $dir = 'images/';
        $file = Str::random(). '.' . $type;
        $absolutePath = public_path($dir);
        $relativePath = $dir . $file;
        if( !File::exists($absolutePath)){
            File::makeDirectory($absolutePath, 0755, true);
        }
        file_put_contents($relativePath, $image);

        return $relativePath;
    }
}
