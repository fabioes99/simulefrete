<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Http\Resources\SupplierResource;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::all();
        return SupplierResource::collection($suppliers);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|unique:supplier,email',
            'name' => 'required|string',
            'phone' => 'required|string',
            'cep' => 'required|string',
            'complemento' => 'required|string',
            'bairro' => 'required|string',
            'localidade' => 'required|string',
            'uf' => 'required|string',
        ]);

        $supplier = Supplier::create($data);

        return new SupplierResource($supplier);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $supplier = Supplier::find($id);

        return new SupplierResource($supplier);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request , $id)
    {
        $data = $request->validate([
            'email' => 'required|string',
            'name' => 'required|string',
            'phone' => 'required|string',
            'cep' => 'required|string',
            'complemento' => 'required|string',
            'bairro' => 'required|string',
            'localidade' => 'required|string',
            'uf' => 'required|string',
        ]);

        $supplier = Supplier::find($id);


        return $supplier->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $supplier = Supplier::find($id);
        return $supplier->delete();
    }
}
