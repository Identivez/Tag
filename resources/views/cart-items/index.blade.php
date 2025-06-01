@extends('layouts.app')

@section('title','Listado de Ítems de Carrito')

@section('content')
  <h1>Ítems de Carrito</h1>
  <a href="{{ route('cart-items.create') }}" class="btn">Crear Ítem</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($items as $item)
        <tr>
          <td>{{ $item->CartId }}</td>
          <td>
            {{ optional($item->user)->firstName }}
            {{ optional($item->user)->lastName }}
          </td>
          <td>{{ optional($item->product)->Name }}</td>
          <td>{{ $item->Quantity }}</td>
          <td>{{ $item->Price }}</td>
          <td>{{ $item->Total }}</td>
          <td>
            <a href="{{ route('cart-items.show', $item) }}" class="btn">Ver</a>
            <a href="{{ route('cart-items.edit', $item) }}" class="btn">Editar</a>
            <form action="{{ route('cart-items.destroy', $item) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar ítem?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7">No hay ítems en el carrito.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
