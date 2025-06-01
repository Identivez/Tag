@extends('layouts.app')

@section('title','Listado de Detalles de Pedido')

@section('content')
  <h1>Detalles de Pedido</h1>
  <a href="{{ route('order-details.create') }}" class="btn">Crear Detalle</a>
<a href="{{ route('pdf.invoice', [1, $order->OrderId]) }}" class="btn btn-primary" target="_blank">
    <i class="fa fa-file-pdf"></i> Ver factura
</a>

<a href="{{ route('pdf.invoice', [2, $order->OrderId]) }}" class="btn btn-secondary">
    <i class="fa fa-download"></i> Descargar factura
</a>
  <table class="table-crud">
    <thead>
      <tr>
        <th>Pedido</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Unit.</th>
        <th>Cupón</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($details as $det)
        <tr>
          <td>{{ $det->OrderId }}</td>
          <td>{{ $det->product->Name }}</td>
          <td>{{ $det->Quantity }}</td>
          <td>{{ $det->UnitPrice }}</td>
          <td>{{ $det->CouponId }}</td>
          <td>
            <a href="{{ route('order-details.show', $det) }}" class="btn">Ver</a>
            <a href="{{ route('order-details.edit', $det) }}" class="btn">Editar</a>
            <form action="{{ route('order-details.destroy', $det) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar detalle?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">No hay detalles registrados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
