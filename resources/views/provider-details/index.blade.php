@extends('layouts.app')

@section('title','Listado de Detalles de Proveedores')

@section('content')
  <h1>Detalles de Proveedores</h1>
  <a href="{{ route('provider-details.create') }}" class="btn">Crear Detalle</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Proveedor</th>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Fecha Suministro</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($details as $det)
        <tr>
          <td>{{ $det->ProviderDetailsId }}</td>
          <td>{{ $det->provider->Name }}</td>
          <td>{{ $det->product->Name }}</td>
          <td>{{ $det->Price }}</td>
          <td>{{ $det->Quantity }}</td>
          <td>{{ optional($det->SupplyDate)->format('d/m/Y') }}</td>
          <td>
            <a href="{{ route('provider-details.show', $det) }}" class="btn">Ver</a>
            <a href="{{ route('provider-details.edit', $det) }}" class="btn">Editar</a>
            <form
              action="{{ route('provider-details.destroy', $det) }}"
              method="POST"
              style="display:inline"
            >
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar detalle?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7">No hay detalles registrados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
