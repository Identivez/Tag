<?php

namespace App\Http\Controllers;

use App\Models\Municipality;
use App\Models\Entity;
use Illuminate\Http\Request;

class MunicipalityController extends Controller
{
    public function index()
    {
        $municipalities = Municipality::with('entity')->get();
        return view('municipalities.index', compact('municipalities'));
    }

    public function create()
    {
        $entities = Entity::orderBy('Name')->get();
        return view('municipalities.create', compact('entities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'EntityId' => 'required|exists:entities,EntityId',
            'Name'     => 'required|string|max:256',
            'Status'   => 'required|in:0,1',
        ]);

        Municipality::create($data);

        return redirect()
            ->route('municipalities.index')
            ->with('success', 'Municipio creado correctamente.');
    }

    public function show(Municipality $municipality)
    {
        $municipality->load('entity');
        return view('municipalities.show', compact('municipality'));
    }

    public function edit(Municipality $municipality)
    {
        $entities = Entity::orderBy('Name')->get();
        return view('municipalities.edit', compact('municipality', 'entities'));
    }

    public function update(Request $request, Municipality $municipality)
    {
        $data = $request->validate([
            'EntityId' => 'required|exists:entities,EntityId',
            'Name'     => 'required|string|max:256',
            'Status'   => 'required|in:0,1',
        ]);

        $municipality->update($data);

        return redirect()
            ->route('municipalities.index')
            ->with('success', 'Municipio actualizado correctamente.');
    }

    public function destroy(Municipality $municipality)
    {
        $municipality->delete();

        return redirect()
            ->route('municipalities.index')
            ->with('success', 'Municipio eliminado correctamente.');
    }
}
