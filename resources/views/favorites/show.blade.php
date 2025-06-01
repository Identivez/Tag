@extends('layouts.app')

@section('title','Detalle de Favorito')

@section('content')
  <h1>Detalle de Favorito</h1>
  <p><strong>ID:</strong> {{ $favorite->FavoriteId }}</p>
  <p>
    <strong>Usuario:</strong>
    {{ optional($favorite->user)->firstName }}
    {{ optional($favorite->user)->lastName }}
  </p>
  <p><strong>Producto:</strong> {{ optional($favorite->product)->Name }}</p>
  <p><strong>Agregado:</strong> {{ optional($favorite->AddedAt)->format('d/m/Y H:i') }}</p>
  <a href="{{ route('favorites.index') }}" class="btn">Volver</a>
@endsection
