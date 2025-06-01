@extends('layouts.app')

@section('title','Editar Pedido')

@section('content')
  <h1>Editar Pedido</h1>
  <form action="{{ route('orders.update', $order) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Pedido</label>
      <input type="text" value="{{ $order->OrderId }}" readonly>
    </div>

    <div class="form-group">
      <label for="OrderDate">Fecha de Pedido</label>
      <input
        type="datetime-local"
        name="OrderDate"
        id="OrderDate"
        value="{{ optional($order->OrderDate)->format('Y-m-d\TH:i') }}"
      >
    </div>

    <div class="form-group">
      <label for="TotalAmount">Total</label>
      <input
        type="text"
        name="TotalAmount"
        id="TotalAmount"
        value="{{ $order->TotalAmount }}"
      >
    </div>

    <div class="form-group">
      <label for="OrderStatus">Estado</label>
      <input
        type="text"
        name="OrderStatus"
        id="OrderStatus"
        value="{{ $order->OrderStatus }}"
        maxlength="20"
      >
    </div>

    <div class="form-group">
      <label for="PaymentId">Pago</label>
      <select name="PaymentId" id="PaymentId">
        <option value="">— Ninguno —</option>
        @foreach($payments as $id => $label)
          <option value="{{ $id }}" {{ $order->PaymentId == $id ? 'selected' : '' }}>
            {{ $label }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ShippingMethod">Método de Envío</label>
      <input
        type="text"
        name="ShippingMethod"
        id="ShippingMethod"
        value="{{ $order->ShippingMethod }}"
        maxlength="50"
      >
    </div>

    <div class="form-group">
      <label for="ShippingCost">Costo de Envío</label>
      <input
        type="text"
        name="ShippingCost"
        id="ShippingCost"
        value="{{ $order->ShippingCost }}"
      >
    </div>

    <div class="form-group">
      <label for="ShippingAddressId">Dirección de Envío</label>
      <select name="ShippingAddressId" id="ShippingAddressId">
        <option value="">— Ninguno —</option>
        @foreach($addresses as $id => $addr)
          <option value="{{ $id }}" {{ $order->ShippingAddressId == $id ? 'selected' : '' }}>
            {{ \Illuminate\Support\Str::limit($addr, 30) }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="BillingAddressId">Dirección de Facturación</label>
      <select name="BillingAddressId" id="BillingAddressId">
        <option value="">— Ninguno —</option>
        @foreach($addresses as $id => $addr)
          <option value="{{ $id }}" {{ $order->BillingAddressId == $id ? 'selected' : '' }}>
            {{ \Illuminate\Support\Str::limit($addr, 30) }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
