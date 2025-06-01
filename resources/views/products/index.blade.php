@extends('layouts.app')

@section('title','Listado de Productos')

@section('content')
  <h1>Productos</h1>
  <a href="{{ route('products.create') }}" class="btn">Crear Producto</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th><th>Nombre</th><th>Precio</th><th>Proveedor</th><th>Categoría</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($products as $prod)
        <tr>
          <td>{{ $prod->ProductId }}</td>
          <td>{{ $prod->Name }}</td>
          <td>{{ number_format($prod->Price,2) }}</td>
          <td>{{ optional($prod->provider)->Name }}</td>
          <td>{{ optional($prod->category)->Name }}</td>
          <td>
            <a href="{{ route('products.show', $prod) }}" class="btn">Ver</a>
            <a href="{{ route('products.edit', $prod) }}" class="btn">Editar</a>
            <form action="{{ route('products.destroy', $prod) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar producto?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="6">No hay productos registrados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
