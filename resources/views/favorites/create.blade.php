@extends('layouts.app')

@section('title','Editar Favorito')

@section('content')
  <h1>Editar Favorito</h1>
  <form action="{{ route('favorites.update', $favorite) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Favorito</label>
      <input type="text" value="{{ $favorite->FavoriteId }}" readonly>
    </div>

    <div class="form-group">
      <label for="UserId">Usuario</label>
      <select name="UserId" id="UserId" required>
        @foreach($users as $id => $name)
          <option value="{{ $id }}" {{ $favorite->UserId == $id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ProductId">Producto</label>
      <select name="ProductId" id="ProductId" required>
        @foreach($products as $id => $name)
          <option value="{{ $id }}" {{ $favorite->ProductId == $id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="AddedAt">Fecha de Agregado</label>
      <input
        type="datetime-local"
        name="AddedAt"
        id="AddedAt"
        value="{{ $favorite->AddedAt?->format('Y-m-d\TH:i') }}"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
