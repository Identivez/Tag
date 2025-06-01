@extends('layouts.app')

@section('title','Crear Pedido')

@section('content')
  <h1>Crear Pedido</h1>
  <form action="{{ route('orders.store') }}" method="POST">
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
      <label for="OrderDate">Fecha de Pedido</label>
      <input type="datetime-local" name="OrderDate" id="OrderDate">
    </div>

    <div class="form-group">
      <label for="TotalAmount">Total</label>
      <input type="text" name="TotalAmount" id="TotalAmount">
    </div>

    <div class="form-group">
      <label for="OrderStatus">Estado</label>
      <input type="text" name="OrderStatus" id="OrderStatus" maxlength="20">
    </div>

    <div class="form-group">
      <label for="PaymentId">Pago</label>
      <select name="PaymentId" id="PaymentId">
        <option value="">— Ninguno —</option>
        @foreach($payments as $id => $label)
          <option value="{{ $id }}">{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ShippingMethod">Método de Envío</label>
      <input type="text" name="ShippingMethod" id="ShippingMethod" maxlength="50">
    </div>

    <div class="form-group">
      <label for="ShippingCost">Costo de Envío</label>
      <input type="text" name="ShippingCost" id="ShippingCost">
    </div>

    <div class="form-group">
      <label for="ShippingAddressId">Dirección de Envío</label>
      <select name="ShippingAddressId" id="ShippingAddressId">
        <option value="">— Ninguno —</option>
        @foreach($addresses as $id => $addr)
          <option value="{{ $id }}">{{ \Illuminate\Support\Str::limit($addr, 30) }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="BillingAddressId">Dirección de Facturación</label>
      <select name="BillingAddressId" id="BillingAddressId">
        <option value="">— Ninguno —</option>
        @foreach($addresses as $id => $addr)
          <option value="{{ $id }}">{{ \Illuminate\Support\Str::limit($addr, 30) }}</option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
