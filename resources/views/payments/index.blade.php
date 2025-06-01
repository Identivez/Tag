@extends('layouts.app')

@section('title','Listado de Pagos')

@section('content')
  <h1>Pagos</h1>
  <a href="{{ route('payments.create') }}" class="btn">Crear Pago</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Pedido</th>
        <th>Usuario</th>
        <th>Método</th>
        <th>Importe</th>
        <th>Estado</th>
        <th>Fecha</th>
        <th>Proveedor</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($payments as $pay)
        <tr>
          <td>{{ $pay->PaymentId }}</td>
          <td>Pedido #{{ $pay->order->OrderId }}</td>
          <td>{{ $pay->user->name }}</td>
          <td>{{ $pay->PaymentMethod }}</td>
          <td>{{ $pay->Amount }}</td>
          <td>{{ $pay->PaymentStatus }}</td>
          <td>{{ optional($pay->TransactionDate)->format('d/m/Y H:i') }}</td>
          <td>{{ $pay->PaymentProvider }}</td>
          <td>
            <a href="{{ route('payments.show', $pay) }}" class="btn">Ver</a>
            <a href="{{ route('payments.edit', $pay) }}" class="btn">Editar</a>
            <form action="{{ route('payments.destroy', $pay) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar pago?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="9">No hay pagos registrados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
