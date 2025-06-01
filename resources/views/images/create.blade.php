@extends('layouts.app')

@section('title','Crear Imagen')

@section('content')
  <h1>Crear Imagen</h1>
  <form action="{{ route('images.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="ProductId">Producto</label>
      <select name="ProductId" id="ProductId" required>
        @foreach($products as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ImageFileName">Nombre de Archivo</label>
      <input type="text" name="ImageFileName" id="ImageFileName">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
