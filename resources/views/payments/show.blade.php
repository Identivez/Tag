@extends('layouts.app')

@section('title','Detalle de Pago')

@section('content')
  <h1>Detalle de Pago</h1>
  <p><strong>ID:</strong> {{ $payment->PaymentId }}</p>
  <p><strong>Pedido:</strong> Pedido #{{ $payment->order->OrderId }}</p>
  <p><strong>Usuario:</strong> {{ $payment->user->name }}</p>
  <p><strong>Método de Pago:</strong> {{ $payment->PaymentMethod }}</p>
  <p><strong>Importe:</strong> {{ $payment->Amount }}</p>
  <p><strong>Estado de Pago:</strong> {{ $payment->PaymentStatus }}</p>
  <p><strong>Fecha de Transacción:</strong> {{ optional($payment->TransactionDate)->format('d/m/Y H:i') }}</p>
  <p><strong>Proveedor de Pago:</strong> {{ $payment->PaymentProvider }}</p>
  <a href="{{ route('payments.index') }}" class="btn">Volver</a>
@endsection
