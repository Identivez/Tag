@extends('layouts.app')
@section('title','Detalle de País')

@section('content')
  <h1>Detalle de País</h1>
  <p><strong>ID:</strong> {{ $country->CountryId }}</p>
  <p><strong>Nombre:</strong> {{ $country->Name }}</p>
  <p><strong>Key:</strong> {{ $country->Key }}</p>
  <p><strong>Status:</strong> {{ $country->Status?'Activo':'Inactivo' }}</p>
  <a href="{{ route('countries.index') }}" class="btn">Volver</a>
@endsection
