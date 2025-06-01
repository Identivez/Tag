@extends('layouts.app')
@section('title','Detalle de Usuario')

@section('content')
  <h1>Detalle de Usuario</h1>

  <p><strong>ID:</strong> {{ $user->UserId }}</p>
  <p><strong>Nombre:</strong> {{ $user->firstName }} {{ $user->lastName }}</p>
  <p><strong>Creado en:</strong> {{ $user->createdAt }}</p>
  <p><strong>Email:</strong> {{ $user->email }}</p>
  <p><strong>Teléfono:</strong> {{ $user->phoneNumber }}</p>
  <p><strong>Municipio:</strong> {{ $user->municipality?->Name ?? '—' }}</p>

  <a href="{{ route('users.index') }}" class="btn">Volver</a>
@endsection
