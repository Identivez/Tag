<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = Size::all();
        return view('sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('sizes.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'SizeValue'  => 'required|string|max:10',
            'SizeRegion' => 'required|string|max:5',
            'SizeType'   => 'required|string|max:10',
            'IsActive'   => 'required|boolean',
        ]);

        Size::create($data);

        return redirect()
            ->route('sizes.index')
            ->with('success', 'Talla creada correctamente.');
    }

    public function show(Size $size)
    {
        return view('sizes.show', compact('size'));
    }

    public function edit(Size $size)
    {
        return view('sizes.edit', compact('size'));
    }

    public function update(Request $request, Size $size)
    {
        $data = $request->validate([
            'SizeValue'  => 'required|string|max:10',
            'SizeRegion' => 'required|string|max:5',
            'SizeType'   => 'required|string|max:10',
            'IsActive'   => 'required|boolean',
        ]);

        $size->update($data);

        return redirect()
            ->route('sizes.index')
            ->with('success', 'Talla actualizada correctamente.');
    }

    public function destroy(Size $size)
    {
        $size->delete();

        return redirect()
            ->route('sizes.index')
            ->with('success', 'Talla eliminada correctamente.');
    }
}
