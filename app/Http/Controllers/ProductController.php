<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Provider;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['provider','category'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $providers  = Provider::pluck('Name','ProviderId');
        $categories = Category::pluck('Name','CategoryId');
        return view('products.create', compact('providers','categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name'        => 'required|string|max:100',
            'Brand'       => 'nullable|string|max:100',
            'Price'       => 'required|numeric',
            'Description' => 'nullable|string',
            'Quantity'    => 'nullable|integer',
            'Stock'       => 'nullable|integer',
            'ProviderId'  => 'nullable|exists:providers,ProviderId',
            'CategoryId'  => 'nullable|exists:categories,CategoryId',
        ]);

        Product::create($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $providers  = Provider::pluck('Name','ProviderId');
        $categories = Category::pluck('Name','CategoryId');
        return view('products.edit', compact('product','providers','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'Name'        => 'required|string|max:100',
            'Brand'       => 'nullable|string|max:100',
            'Price'       => 'required|numeric',
            'Description' => 'nullable|string',
            'Quantity'    => 'nullable|integer',
            'Stock'       => 'nullable|integer',
            'ProviderId'  => 'nullable|exists:providers,ProviderId',
            'CategoryId'  => 'nullable|exists:categories,CategoryId',
        ]);

        $product->update($data);

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
