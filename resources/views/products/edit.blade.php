@extends('layouts.app')

@section('title','Editar Producto')

@section('content')
  <h1>Editar Producto</h1>
  <form action="{{ route('products.update', $product) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Producto</label>
      <input type="text" value="{{ $product->ProductId }}" readonly>
    </div>

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input
        type="text"
        name="Name"
        id="Name"
        value="{{ $product->Name }}"
        maxlength="100"
        required
      >
    </div>

    <div class="form-group">
      <label for="Brand">Marca</label>
      <input
        type="text"
        name="Brand"
        id="Brand"
        value="{{ $product->Brand }}"
        maxlength="100"
      >
    </div>

    <div class="form-group">
      <label for="Price">Precio</label>
      <input
        type="number"
        name="Price"
        id="Price"
        step="0.01"
        value="{{ $product->Price }}"
        required
      >
    </div>

    <div class="form-group">
      <label for="Description">Descripción</label>
      <textarea name="Description" id="Description">{{ $product->Description }}</textarea>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input
        type="number"
        name="Quantity"
        id="Quantity"
        value="{{ $product->Quantity }}"
      >
    </div>

    <div class="form-group">
      <label for="Stock">Stock</label>
      <input
        type="number"
        name="Stock"
        id="Stock"
        value="{{ $product->Stock }}"
      >
    </div>

    <div class="form-group">
      <label for="ProviderId">Proveedor</label>
      <select name="ProviderId" id="ProviderId">
        <option value="">— Selecciona proveedor —</option>
        @foreach($providers as $id => $name)
          <option value="{{ $id }}"
            {{ $product->ProviderId == $id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="CategoryId">Categoría</label>
      <select name="CategoryId" id="CategoryId">
        <option value="">— Selecciona categoría —</option>
        @foreach($categories as $id => $name)
          <option value="{{ $id }}"
            {{ $product->CategoryId == $id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
