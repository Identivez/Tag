@extends('layouts.app')

@section('title','Listado de Categorías')

@section('content')
  <h1>Categorías</h1>
  <a href="{{ route('categories.create') }}" class="btn">Crear Categoría</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Descripción</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($categories as $category)
        <tr>
          <td>{{ $category->CategoryId }}</td>
          <td>{{ $category->Name }}</td>
          <td>{{ \Illuminate\Support\Str::limit($category->Description, 50) }}</td>
          <td>
            <a href="{{ route('categories.show', $category) }}" class="btn">Ver</a>
            <a href="{{ route('categories.edit', $category) }}" class="btn">Editar</a>
            <form
              action="{{ route('categories.destroy', $category) }}"
              method="POST"
              style="display:inline"
            >
              @csrf
              @method('DELETE')
              <button
                type="submit"
                class="btn"
                onclick="return confirm('¿Eliminar categoría?')"
              >
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4">No hay categorías registradas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
