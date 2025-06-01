@extends('layouts.app')

@section('title','Listado de Proveedores')

@section('content')
  <h1>Proveedores</h1>
  <a href="{{ route('providers.create') }}" class="btn">Crear Proveedor</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Contacto</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($providers as $prov)
        <tr>
          <td>{{ $prov->ProviderId }}</td>
          <td>{{ $prov->Name }}</td>
          <td>{{ $prov->ContactEmail }}</td>
          <td>{{ $prov->ContactPhone }}</td>
          <td>{{ \Illuminate\Support\Str::limit($prov->Address, 30) }}</td>
          <td>{{ $prov->ContactName }}</td>
          <td>
            <a href="{{ route('providers.show', $prov) }}" class="btn">Ver</a>
            <a href="{{ route('providers.edit', $prov) }}" class="btn">Editar</a>
            <form action="{{ route('providers.destroy', $prov) }}"
                  method="POST"
                  style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn"
                      onclick="return confirm('¿Eliminar proveedor?')">
                Eliminar
              </button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="7">No hay proveedores registrados.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
