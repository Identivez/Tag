@extends('layouts.app')

@section('title','Listado de Imágenes')

@section('content')
  <h1>Imágenes</h1>
  <a href="{{ route('images.create') }}" class="btn">Crear Imagen</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Producto</th>
        <th>Archivo</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($images as $img)
        <tr>
          <td>{{ $img->ImageId }}</td>
          <td>{{ $img->product->Name }}</td>
          <td>{{ $img->ImageFileName }}</td>
          <td>
            <a href="{{ route('images.show', $img) }}" class="btn">Ver</a>
            <a href="{{ route('images.edit', $img) }}" class="btn">Editar</a>
            <form action="{{ route('images.destroy', $img) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar imagen?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="4">No hay imágenes registradas.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
