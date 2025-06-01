@extends('layouts.app')

@section('title','Detalle de Detalle de Proveedor')

@section('content')
  <h1>Detalle de Proveedor</h1>
  <p><strong>ID:</strong> {{ $providerDetail->ProviderDetailsId }}</p>
  <p><strong>Proveedor:</strong> {{ $providerDetail->provider->Name }}</p>
  <p><strong>Producto:</strong> {{ $providerDetail->product->Name }}</p>
  <p><strong>Precio:</strong> {{ $providerDetail->Price }}</p>
  <p><strong>Cantidad:</strong> {{ $providerDetail->Quantity }}</p>
  <p><strong>Fecha de Suministro:</strong> {{ optional($providerDetail->SupplyDate)->format('d/m/Y') }}</p>
  <a href="{{ route('provider-details.index') }}" class="btn">Volver</a>
@endsection
