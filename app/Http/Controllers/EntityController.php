<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use App\Models\Country;
use Illuminate\Http\Request;

class EntityController extends Controller
{
    public function index()
    {
        // Carga todas las entidades con su país asociado
        $entities = Entity::with('country')->get();
        return view('entities.index', compact('entities'));
    }

    public function create()
    {
        // Necesitamos la lista de países para el select
        $countries = Country::orderBy('Name')->get();
        return view('entities.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'CountryId' => 'required|exists:countries,CountryId',
            'Name'      => 'required|string|max:256',
            'Status'    => 'required|in:0,1',
        ]);

        Entity::create($data);

        return redirect()
            ->route('entities.index')
            ->with('success', 'Entidad creada correctamente.');
    }

    public function show(Entity $entity)
    {
        $entity->load('country');
        return view('entities.show', compact('entity'));
    }

    public function edit(Entity $entity)
    {
        $countries = Country::orderBy('Name')->get();
        return view('entities.edit', compact('entity', 'countries'));
    }

    public function update(Request $request, Entity $entity)
    {
        $data = $request->validate([
            'CountryId' => 'required|exists:countries,CountryId',
            'Name'      => 'required|string|max:256',
            'Status'    => 'required|in:0,1',
        ]);

        $entity->update($data);

        return redirect()
            ->route('entities.index')
            ->with('success', 'Entidad actualizada correctamente.');
    }

    public function destroy(Entity $entity)
    {
        $entity->delete();

        return redirect()
            ->route('entities.index')
            ->with('success', 'Entidad eliminada correctamente.');
    }
}
