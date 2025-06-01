@extends('layouts.app')

@section('title','Detalle de Dirección')

@section('content')
  <h1>Detalle de Dirección</h1>
  <p><strong>ID:</strong> {{ $address->AddressId }}</p>
  <p><strong>Usuario:</strong> {{ $address->user->name }}</p>
  <p><strong>Dirección Línea 1:</strong> {{ $address->AddressLine1 }}</p>
  <p><strong>Dirección Línea 2:</strong> {{ $address->AddressLine2 }}</p>
  <p><strong>Ciudad:</strong> {{ $address->City }}</p>
  <p><strong>Estado:</strong> {{ $address->State }}</p>
  <p><strong>Código Postal:</strong> {{ $address->ZipCode }}</p>
  <p><strong>País (texto):</strong> {{ $address->Country }}</p>
  <p><strong>País (vínculo):</strong> {{ optional($address->country)->Name }}</p>
  <p><strong>Municipio:</strong> {{ optional($address->municipality)->Name }}</p>
  <p><strong>Tipo de Dirección:</strong> {{ $address->AddressType }}</p>
  <p><strong>Predeterminada:</strong> {{ $address->IsDefault ? 'Sí' : 'No' }}</p>
  <p><strong>Activo:</strong> {{ $address->IsActive ? 'Sí' : 'No' }}</p>
  <p><strong>Creado:</strong> {{ $address->CreatedAt }}</p>
  <p><strong>Actualizado:</strong> {{ $address->UpdatedAt }}</p>
  <a href="{{ route('addresses.index') }}" class="btn">Volver</a>
@endsection
