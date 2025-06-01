<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        $providers = Provider::all();
        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'Name'         => 'nullable|string|max:255',
            'ContactEmail' => 'nullable|email|max:256',
            'ContactPhone' => 'nullable|string|max:20',
            'Address'      => 'nullable|string',
            'ContactName'  => 'nullable|string|max:256',
        ]);

        Provider::create($data);

        return redirect()
            ->route('providers.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function show(Provider $provider)
    {
        return view('providers.show', compact('provider'));
    }

    public function edit(Provider $provider)
    {
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, Provider $provider)
    {
        $data = $request->validate([
            'Name'         => 'nullable|string|max:255',
            'ContactEmail' => 'nullable|email|max:256',
            'ContactPhone' => 'nullable|string|max:20',
            'Address'      => 'nullable|string',
            'ContactName'  => 'nullable|string|max:256',
        ]);

        $provider->update($data);

        return redirect()
            ->route('providers.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Provider $provider)
    {
        $provider->delete();

        return redirect()
            ->route('providers.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}
