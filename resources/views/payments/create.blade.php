@extends('layouts.app')

@section('title','Crear Pago')

@section('content')
  <h1>Crear Pago</h1>
  <form action="{{ route('payments.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="OrderId">Pedido</label>
      <select name="OrderId" id="OrderId" required>
        @foreach($orders as $id => $label)
          <option value="{{ $id }}">Pedido #{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="UserId">Usuario</label>
      <select name="UserId" id="UserId" required>
        @foreach($users as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="PaymentMethod">Método de Pago</label>
      <input type="text" name="PaymentMethod" id="PaymentMethod" maxlength="50">
    </div>

    <div class="form-group">
      <label for="Amount">Importe</label>
      <input type="text" name="Amount" id="Amount">
    </div>

    <div class="form-group">
      <label for="PaymentStatus">Estado de Pago</label>
      <input type="text" name="PaymentStatus" id="PaymentStatus" maxlength="20">
    </div>

    <div class="form-group">
      <label for="TransactionDate">Fecha de Transacción</label>
      <input type="datetime-local" name="TransactionDate" id="TransactionDate">
    </div>

    <div class="form-group">
      <label for="PaymentProvider">Proveedor de Pago</label>
      <input type="text" name="PaymentProvider" id="PaymentProvider" maxlength="50">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
