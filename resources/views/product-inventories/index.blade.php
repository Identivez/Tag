@extends('layouts.app')

@section('title','Listado de Inventarios')

@section('content')
  <h1>Inventarios de Productos</h1>
  <a href="{{ route('product-inventories.create') }}" class="btn">Crear Inventario</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Talla</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>SKU</th>
        <th>Condición</th>
        <th>En Stock</th>
        <th>Nivel Reorden</th>
        <th>Última Actualización</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($inventories as $inv)
        <tr>
          <td>{{ $inv->InventoryId }}</td>
          <td>{{ $inv->product->Name }}</td>
          <td>{{ $inv->size->SizeValue }} ({{ $inv->size->SizeRegion }}-{{ $inv->size->SizeType }})</td>
          <td>{{ $inv->Quantity }}</td>
          <td>{{ $inv->Price }}</td>
          <td>{{ $inv->SKU }}</td>
          <td>{{ $inv->Condition }}</td>
          <td>{{ $inv->InStock ? 'Sí' : 'No' }}</td>
          <td>{{ $inv->ReorderLevel }}</td>
          <td>{{ $inv->LastUpdated }}</td>
          <td>
            <a href="{{ route('product-inventories.show', $inv) }}" class="btn">Ver</a>
            <a href="{{ route('product-inventories.edit', $inv) }}" class="btn">Editar</a>
            <form action="{{ route('product-inventories.destroy', $inv) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar inventario?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="11">No hay inventarios registrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
