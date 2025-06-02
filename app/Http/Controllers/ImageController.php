<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'ProductId' => 'required|exists:products,ProductId',
            'image'     => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Almacenar archivo en storage/app/public/images
        $path = $request->file('image')->store('images', 'public');

        Image::create([
            'ProductId' => $request->ProductId,
            'ImageFileName' => $path, // Guardamos la ruta relativa
        ]);

        return redirect()->route('images.index')->with('success', 'Archivo subido correctamente.');
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
        $request->validate([
            'image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Borrar archivo anterior si existe
            if ($image->ImageFileName && Storage::disk('public')->exists($image->ImageFileName)) {
                Storage::disk('public')->delete($image->ImageFileName);
            }

            // Subir nuevo archivo
            $path = $request->file('image')->store('images', 'public');
            $image->update(['ImageFileName' => $path]);
        }

        return redirect()->route('images.index')->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroy(Image $image)
    {
        // Eliminar archivo físico si existe
        if ($image->ImageFileName && Storage::disk('public')->exists($image->ImageFileName)) {
            Storage::disk('public')->delete($image->ImageFileName);
        }

        $image->delete();

        return redirect()->route('images.index')->with('success', 'Imagen eliminada correctamente.');
    }
}
