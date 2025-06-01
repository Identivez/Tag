@extends('layouts.app')

@section('title','Listado de Tallas')

@section('content')
  <h1>Tallas</h1>
  <a href="{{ route('sizes.create') }}" class="btn">Crear Talla</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Valor</th>
        <th>Región</th>
        <th>Tipo</th>
        <th>Activo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($sizes as $item)
        <tr>
          <td>{{ $item->SizeId }}</td>
          <td>{{ $item->SizeValue }}</td>
          <td>{{ $item->SizeRegion }}</td>
          <td>{{ $item->SizeType }}</td>
          <td>{{ $item->IsActive ? 'Sí' : 'No' }}</td>
          <td>
            <a href="{{ route('sizes.show', $item) }}" class="btn">Ver</a>
            <a href="{{ route('sizes.edit', $item) }}" class="btn">Editar</a>
            <form action="{{ route('sizes.destroy', $item) }}" method="POST" style="display:inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar talla?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="6">No hay tallas registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
