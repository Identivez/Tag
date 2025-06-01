@extends('layouts.app')

@section('title','Detalle de Pedido')

@section('content')
  <h1>Detalle de Pedido</h1>
  <p><strong>Pedido:</strong> {{ $orderDetail->OrderId }}</p>
  <p><strong>Producto:</strong> {{ $orderDetail->product->Name }}</p>
  <p><strong>Cantidad:</strong> {{ $orderDetail->Quantity }}</p>
  <p><strong>Precio Unitario:</strong> {{ $orderDetail->UnitPrice }}</p>
  <p><strong>Cupón (ID):</strong> {{ $orderDetail->CouponId }}</p>
  <a href="{{ route('order-details.index') }}" class="btn">Volver</a>
@endsection
