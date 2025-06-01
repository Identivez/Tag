@extends('layouts.app')

@section('title','Editar Imagen')

@section('content')
  <h1>Editar Imagen</h1>
  <form action="{{ route('images.update', $image) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Imagen</label>
      <input type="text" value="{{ $image->ImageId }}" readonly>
    </div>

    <div class="form-group">
      <label>Producto</label>
      <input type="text" value="{{ $image->product->Name }}" readonly>
    </div>

    <div class="form-group">
      <label for="ImageFileName">Nombre de Archivo</label>
      <input
        type="text"
        name="ImageFileName"
        id="ImageFileName"
        value="{{ $image->ImageFileName }}"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
