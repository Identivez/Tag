@extends('layouts.app')

@section('title','Crear Producto')

@section('content')
  <h1>Crear Producto</h1>
  <form action="{{ route('products.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" maxlength="100" required>
    </div>

    <div class="form-group">
      <label for="Brand">Marca</label>
      <input type="text" name="Brand" id="Brand" maxlength="100">
    </div>

    <div class="form-group">
      <label for="Price">Precio</label>
      <input type="number" name="Price" id="Price" step="0.01" required>
    </div>

    <div class="form-group">
      <label for="Description">Descripción</label>
      <textarea name="Description" id="Description"></textarea>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input type="number" name="Quantity" id="Quantity">
    </div>

    <div class="form-group">
      <label for="Stock">Stock</label>
      <input type="number" name="Stock" id="Stock">
    </div>

    <div class="form-group">
      <label for="ProviderId">Proveedor</label>
      <select name="ProviderId" id="ProviderId">
        <option value="">— Selecciona proveedor —</option>
        @foreach($providers as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="CategoryId">Categoría</label>
      <select name="CategoryId" id="CategoryId">
        <option value="">— Selecciona categoría —</option>
        @foreach($categories as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
