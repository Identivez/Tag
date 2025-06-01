@extends('layouts.app')

@section('title','Listado de Pedidos')

@section('content')
  <h1>Pedidos</h1>
  <a href="{{ route('orders.create') }}" class="btn">Crear Pedido</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Fecha Pedido</th>
        <th>Total</th>
        <th>Estado</th>
        <th>Pago</th>
        <th>Método Envío</th>
        <th>Costo Envío</th>
        <th>Envío</th>
        <th>Facturación</th>
        <th>Creado</th>
        <th>Actualizado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($orders as $ord)
        <tr>
          <td>{{ $ord->OrderId }}</td>
          <td>{{ $ord->user->name }}</td>
          <td>{{ optional($ord->OrderDate)->format('d/m/Y H:i') }}</td>
          <td>{{ $ord->TotalAmount }}</td>
          <td>{{ $ord->OrderStatus }}</td>
          <td>{{ $ord->PaymentId }}</td>
          <td>{{ $ord->ShippingMethod }}</td>
          <td>{{ $ord->ShippingCost }}</td>
          <td>{{ optional($ord->shippingAddress)->AddressLine1 }}</td>
          <td>{{ optional($ord->billingAddress)->AddressLine1 }}</td>
          <td>{{ optional($ord->CreatedAt)->format('d/m/Y H:i') }}</td>
          <td>{{ optional($ord->UpdatedAt)->format('d/m/Y H:i') }}</td>
          <td>
            <a href="{{ route('orders.show', $ord) }}" class="btn">Ver</a>
            <a href="{{ route('orders.edit', $ord) }}" class="btn">Editar</a>
            <form action="{{ route('orders.destroy', $ord) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar pedido?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="13">No hay pedidos registrados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
