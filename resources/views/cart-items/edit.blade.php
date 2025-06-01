@extends('layouts.app')

@section('title','Editar Ítem de Carrito')

@section('content')
  <h1>Editar Ítem de Carrito</h1>
  <form action="{{ route('cart-items.update', $cartItem) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Ítem</label>
      <input type="text" value="{{ $cartItem->CartId }}" readonly>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input
        type="number"
        name="Quantity"
        id="Quantity"
        value="{{ $cartItem->Quantity }}"
        min="1"
        required
      >
    </div>

    <div class="form-group">
      <label for="Price">Precio Unitario</label>
      <input
        type="text"
        name="Price"
        id="Price"
        value="{{ $cartItem->Price }}"
        required
      >
    </div>

    <div class="form-group">
      <label for="Total">Total (opcional)</label>
      <input
        type="text"
        name="Total"
        id="Total"
        value="{{ $cartItem->Total }}"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
