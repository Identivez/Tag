<?php

namespace App\Http\Controllers;

use App\Models\ProviderDetail;
use App\Models\Provider;
use App\Models\Product;
use Illuminate\Http\Request;

class ProviderDetailController extends Controller
{
    public function index()
    {
        $details = ProviderDetail::with(['provider','product'])->get();
        return view('provider-details.index', compact('details'));
    }

    public function create()
    {
        $providers = Provider::pluck('Name', 'ProviderId');
        $products  = Product::pluck('Name',  'ProductId');
        return view('provider-details.create', compact('providers','products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ProviderId'  => 'required|exists:providers,ProviderId',
            'ProductId'   => 'required|exists:products,ProductId',
            'Price'       => 'nullable|numeric|min:0',
            'Quantity'    => 'nullable|integer|min:0',
            'SupplyDate'  => 'nullable|date',
        ]);

        ProviderDetail::create($data);

        return redirect()
            ->route('provider-details.index')
            ->with('success', 'Detalle de proveedor creado correctamente.');
    }

    public function show(ProviderDetail $providerDetail)
    {
        return view('provider-details.show', compact('providerDetail'));
    }

    public function edit(ProviderDetail $providerDetail)
    {
        $providers = Provider::pluck('Name', 'ProviderId');
        $products  = Product::pluck('Name',  'ProductId');
        return view('provider-details.edit', compact('providerDetail','providers','products'));
    }

    public function update(Request $request, ProviderDetail $providerDetail)
    {
        $data = $request->validate([
            'Price'       => 'nullable|numeric|min:0',
            'Quantity'    => 'nullable|integer|min:0',
            'SupplyDate'  => 'nullable|date',
        ]);

        $providerDetail->update($data);

        return redirect()
            ->route('provider-details.index')
            ->with('success', 'Detalle de proveedor actualizado correctamente.');
    }

    public function destroy(ProviderDetail $providerDetail)
    {
        $providerDetail->delete();

        return redirect()
            ->route('provider-details.index')
            ->with('success', 'Detalle de proveedor eliminado correctamente.');
    }
}
