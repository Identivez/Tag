@extends('layouts.app')
@section('title','Listado de Países')

@section('content')
  <h1>Países</h1>
  <a href="{{ route('countries.create') }}" class="btn">Crear País</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th><th>Nombre</th><th>Key</th><th>Status</th><th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($countries as $country)
        <tr>
          <td>{{ $country->CountryId }}</td>
          <td>{{ $country->Name }}</td>
          <td>{{ $country->Key }}</td>
          <td>{{ $country->Status ? 'Activo':'Inactivo' }}</td>
          <td>
            <a href="{{ route('countries.show',$country) }}" class="btn">Ver</a>
            <a href="{{ route('countries.edit',$country) }}" class="btn">Editar</a>
            <form action="{{ route('countries.destroy',$country) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar país?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5">No hay países creados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
