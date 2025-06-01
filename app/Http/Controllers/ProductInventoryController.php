<?php

namespace App\Http\Controllers;

use App\Models\ProductInventory;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = ProductInventory::with(['product', 'size'])->get();
        return view('product-inventories.index', compact('inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Para el select de productos
        $products = Product::pluck('Name', 'ProductId');
        // Primero obtenemos la colección y luego formateamos las tallas
        $sizes = Size::all()->mapWithKeys(function($s) {
            return [
                $s->SizeId => "{$s->SizeValue} ({$s->SizeRegion}-{$s->SizeType})"
            ];
        });

        return view('product-inventories.create', compact('products', 'sizes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'ProductId'    => 'required|exists:products,ProductId',
            'SizeId'       => 'required|exists:sizes,SizeId',
            'Quantity'     => 'required|integer|min:0',
            'Price'        => 'nullable|numeric|min:0',
            'SKU'          => 'nullable|string|max:50',
            'Condition'    => 'required|string|max:20',
            'InStock'      => 'required|boolean',
            'ReorderLevel' => 'required|integer|min:0',
        ]);

        ProductInventory::create($data);

        return redirect()
            ->route('product-inventories.index')
            ->with('success', 'Inventario de producto creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductInventory $productInventory)
    {
        return view('product-inventories.show', compact('productInventory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductInventory $productInventory)
    {
        $products = Product::pluck('Name', 'ProductId');
        $sizes = Size::all()->mapWithKeys(function($s) {
            return [
                $s->SizeId => "{$s->SizeValue} ({$s->SizeRegion}-{$s->SizeType})"
            ];
        });

        return view('product-inventories.edit', compact('productInventory', 'products', 'sizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductInventory $productInventory)
    {
        $data = $request->validate([
            'ProductId'    => 'required|exists:products,ProductId',
            'SizeId'       => 'required|exists:sizes,SizeId',
            'Quantity'     => 'required|integer|min:0',
            'Price'        => 'nullable|numeric|min:0',
            'SKU'          => 'nullable|string|max:50',
            'Condition'    => 'required|string|max:20',
            'InStock'      => 'required|boolean',
            'ReorderLevel' => 'required|integer|min:0',
        ]);

        $productInventory->update($data);

        return redirect()
            ->route('product-inventories.index')
            ->with('success', 'Inventario de producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductInventory $productInventory)
    {
        $productInventory->delete();

        return redirect()
            ->route('product-inventories.index')
            ->with('success', 'Inventario de producto eliminado correctamente.');
    }
}
