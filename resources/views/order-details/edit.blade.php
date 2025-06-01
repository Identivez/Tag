@extends('layouts.app')

@section('title','Editar Detalle de Pedido')

@section('content')
  <h1>Editar Detalle de Pedido</h1>
  <form action="{{ route('order-details.update', $orderDetail) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>Pedido</label>
      <input type="text" value="{{ $orderDetail->OrderId }}" readonly>
    </div>

    <div class="form-group">
      <label>Producto</label>
      <input type="text" value="{{ $orderDetail->product->Name }}" readonly>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input
        type="number"
        name="Quantity"
        id="Quantity"
        value="{{ $orderDetail->Quantity }}"
        min="1"
        required
      >
    </div>

    <div class="form-group">
      <label for="UnitPrice">Precio Unitario</label>
      <input
        type="text"
        name="UnitPrice"
        id="UnitPrice"
        value="{{ $orderDetail->UnitPrice }}"
      >
    </div>

    <div class="form-group">
      <label for="CouponId">Cupón (ID)</label>
      <input
        type="number"
        name="CouponId"
        id="CouponId"
        value="{{ $orderDetail->CouponId }}"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
