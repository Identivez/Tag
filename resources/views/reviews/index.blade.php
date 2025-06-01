@extends('layouts.app')

@section('title','Listado de Reseñas')

@section('content')
  <h1>Reseñas</h1>
  <a href="{{ route('reviews.create') }}" class="btn">Crear Reseña</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Usuario</th>
        <th>Calificación</th>
        <th>Comentario</th>
        <th>Fecha</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($reviews as $rev)
        <tr>
          <td>{{ $rev->ReviewId }}</td>
          <td>{{ optional($rev->product)->Name }}</td>
          <td>
            {{ optional($rev->user)->firstName }}
            {{ optional($rev->user)->lastName }}
          </td>
          <td>{{ $rev->Rating }}</td>
          <td>{{ \Illuminate\Support\Str::limit($rev->Comment, 50) }}</td>
          <td>{{ optional($rev->ReviewDate)->format('d/m/Y H:i') }}</td>
          <td>
            <a href="{{ route('reviews.show', $rev) }}" class="btn">Ver</a>
            <a href="{{ route('reviews.edit', $rev) }}" class="btn">Editar</a>
            <form action="{{ route('reviews.destroy', $rev) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar reseña?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="7">No hay reseñas registradas.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
