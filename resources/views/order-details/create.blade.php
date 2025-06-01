@extends('layouts.app')

@section('title','Crear Detalle de Pedido')

@section('content')
  <h1>Crear Detalle de Pedido</h1>
  <form action="{{ route('order-details.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="OrderId">Pedido</label>
      <select name="OrderId" id="OrderId" required>
        @foreach($orders as $id)
          <option value="{{ $id }}">Pedido #{{ $id }}</option>
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
      <label for="UnitPrice">Precio Unitario</label>
      <input type="text" name="UnitPrice" id="UnitPrice">
    </div>

    <div class="form-group">
      <label for="CouponId">Cupón (ID)</label>
      <input type="number" name="CouponId" id="CouponId">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
