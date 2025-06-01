@extends('layouts.app')

@section('title','Detalle de Pedido')

@section('content')
  <h1>Detalle de Pedido</h1>
  <p><strong>ID:</strong> {{ $order->OrderId }}</p>
  <p><strong>Usuario:</strong> {{ $order->user->name }}</p>
  <p><strong>Fecha Pedido:</strong> {{ optional($order->OrderDate)->format('d/m/Y H:i') }}</p>
  <p><strong>Total:</strong> {{ $order->TotalAmount }}</p>
  <p><strong>Estado:</strong> {{ $order->OrderStatus }}</p>
  <p><strong>Pago:</strong> {{ $order->PaymentId }}</p>
  <p><strong>Método Envío:</strong> {{ $order->ShippingMethod }}</p>
  <p><strong>Costo Envío:</strong> {{ $order->ShippingCost }}</p>
  <p><strong>Dirección Envío:</strong> {{ optional($order->shippingAddress)->AddressLine1 }}</p>
  <p><strong>Dirección Facturación:</strong> {{ optional($order->billingAddress)->AddressLine1 }}</p>
  <p><strong>Creado:</strong> {{ optional($order->CreatedAt)->format('d/m/Y H:i') }}</p>
  <p><strong>Actualizado:</strong> {{ optional($order->UpdatedAt)->format('d/m/Y H:i') }}</p>
  <a href="{{ route('orders.index') }}" class="btn">Volver</a>
@endsection
