<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::with('product')->get();
        return view('images.index', compact('images'));
    }

    public function create()
    {
        $products = Product::pluck('Name', 'ProductId');
        return view('images.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ProductId'     => 'required|exists:products,ProductId',
            'ImageFileName' => 'nullable|string',
        ]);

        Image::create($data);

        return redirect()
            ->route('images.index')
            ->with('success', 'Imagen creada correctamente.');
    }

    public function show(Image $image)
    {
        return view('images.show', compact('image'));
    }

    public function edit(Image $image)
    {
        $products = Product::pluck('Name', 'ProductId');
        return view('images.edit', compact('image','products'));
    }

    public function update(Request $request, Image $image)
    {
        $data = $request->validate([
            'ImageFileName' => 'nullable|string',
        ]);

        // Solo actualizamos el filename; el ProductId permanece fijo
        $image->update($data);

        return redirect()
            ->route('images.index')
            ->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroy(Image $image)
    {
        $image->delete();

        return redirect()
            ->route('images.index')
            ->with('success', 'Imagen eliminada correctamente.');
    }
}
