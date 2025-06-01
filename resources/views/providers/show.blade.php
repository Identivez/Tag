@extends('layouts.app')

@section('title','Detalle de Proveedor')

@section('content')
  <h1>Detalle de Proveedor</h1>
  <p><strong>ID:</strong> {{ $provider->ProviderId }}</p>
  <p><strong>Nombre:</strong> {{ $provider->Name }}</p>
  <p><strong>Email:</strong> {{ $provider->ContactEmail }}</p>
  <p><strong>Teléfono:</strong> {{ $provider->ContactPhone }}</p>
  <p><strong>Dirección:</strong> {{ $provider->Address }}</p>
  <p><strong>Contacto:</strong> {{ $provider->ContactName }}</p>
  <a href="{{ route('providers.index') }}" class="btn">Volver</a>
@endsection
