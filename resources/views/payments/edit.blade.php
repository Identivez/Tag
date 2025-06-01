@extends('layouts.app')

@section('title','Editar Pago')

@section('content')
  <h1>Editar Pago</h1>
  <form action="{{ route('payments.update', $payment) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label>ID Pago</label>
      <input type="text" value="{{ $payment->PaymentId }}" readonly>
    </div>

    <div class="form-group">
      <label for="PaymentMethod">Método de Pago</label>
      <input
        type="text"
        name="PaymentMethod"
        id="PaymentMethod"
        value="{{ $payment->PaymentMethod }}"
        maxlength="50"
      >
    </div>

    <div class="form-group">
      <label for="Amount">Importe</label>
      <input
        type="text"
        name="Amount"
        id="Amount"
        value="{{ $payment->Amount }}"
      >
    </div>

    <div class="form-group">
      <label for="PaymentStatus">Estado de Pago</label>
      <input
        type="text"
        name="PaymentStatus"
        id="PaymentStatus"
        value="{{ $payment->PaymentStatus }}"
        maxlength="20"
      >
    </div>

    <div class="form-group">
      <label for="TransactionDate">Fecha de Transacción</label>
      <input
        type="datetime-local"
        name="TransactionDate"
        id="TransactionDate"
        value="{{ optional($payment->TransactionDate)->format('Y-m-d\TH:i') }}"
      >
    </div>

    <div class="form-group">
      <label for="PaymentProvider">Proveedor de Pago</label>
      <input
        type="text"
        name="PaymentProvider"
        id="PaymentProvider"
        value="{{ $payment->PaymentProvider }}"
        maxlength="50"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
