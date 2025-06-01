<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();
        return view('countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'Name'   => 'required|string|max:255',
            'Key'    => 'required|string|max:5',
            'Status' => 'required|in:0,1',
        ]);

        Country::create($data);

        return redirect()
            ->route('countries.index')
            ->with('success', 'País creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $data = $request->validate([
            'Name'   => 'required|string|max:255',
            'Key'    => 'required|string|max:5',
            'Status' => 'required|in:0,1',
        ]);

        $country->update($data);

        return redirect()
            ->route('countries.index')
            ->with('success', 'País actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return redirect()
            ->route('countries.index')
            ->with('success', 'País eliminado correctamente.');
    }
}
