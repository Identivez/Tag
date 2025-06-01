@extends('layouts.app')

@section('title','Crear Ítem de Carrito')

@section('content')
  <h1>Crear Ítem de Carrito</h1>
  <form action="{{ route('cart-items.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="UserId">Usuario</label>
      <select name="UserId" id="UserId" required>
        @foreach($users as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ProductId">Producto</label>
      <select name="ProductId" id="ProductId" required>
        @foreach($products as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input type="number" name="Quantity" id="Quantity" value="1" min="1" required>
    </div>

    <div class="form-group">
      <label for="Price">Precio Unitario</label>
      <input type="text" name="Price" id="Price" required>
    </div>

    <div class="form-group">
      <label for="Total">Total (opcional)</label>
      <input type="text" name="Total" id="Total">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
