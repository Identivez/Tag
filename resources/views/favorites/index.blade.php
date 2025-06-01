@extends('layouts.app')

@section('title','Listado de Favoritos')

@section('content')
  <h1>Favoritos</h1>
  <a href="{{ route('favorites.create') }}" class="btn">Crear Favorito</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Producto</th>
        <th>Agregado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($favorites as $fav)
        <tr>
          <td>{{ $fav->FavoriteId }}</td>
          <td>
            {{ optional($fav->user)->firstName }}
            {{ optional($fav->user)->lastName }}
          </td>
          <td>{{ optional($fav->product)->Name }}</td>
          <td>{{ optional($fav->AddedAt)->format('d/m/Y H:i') }}</td>
          <td>
            <a href="{{ route('favorites.show', $fav) }}" class="btn">Ver</a>
            <a href="{{ route('favorites.edit', $fav) }}" class="btn">Editar</a>
            <form action="{{ route('favorites.destroy', $fav) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar favorito?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5">No hay favoritos registrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
