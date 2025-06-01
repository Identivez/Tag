@extends('layouts.app')

@section('title','Detalle Ítem de Carrito')

@section('content')
  <h1>Detalle Ítem de Carrito</h1>
  <p><strong>ID:</strong> {{ $cartItem->CartId }}</p>
  <p>
    <strong>Usuario:</strong>
    {{ optional($cartItem->user)->firstName }}
    {{ optional($cartItem->user)->lastName }}
  </p>
  <p><strong>Producto:</strong> {{ optional($cartItem->product)->Name }}</p>
  <p><strong>Cantidad:</strong> {{ $cartItem->Quantity }}</p>
  <p><strong>Precio Unitario:</strong> {{ $cartItem->Price }}</p>
  <p><strong>Total:</strong> {{ $cartItem->Total }}</p>
  <a href="{{ route('cart-items.index') }}" class="btn">Volver</a>
@endsection
