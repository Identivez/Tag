@extends('layouts.app')
@section('title','Listado de Municipios')

@section('content')
  <h1>Municipios</h1>
  <a href="{{ route('municipalities.create') }}" class="btn">Crear Municipio</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Entidad</th>
        <th>Nombre</th>
        <th>Status</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($municipalities as $mun)
        <tr>
          <td>{{ $mun->MunId }}</td>
          <td>{{ $mun->entity->Name }}</td>
          <td>{{ $mun->Name }}</td>
          <td>{{ $mun->Status ? 'Activo' : 'Inactivo' }}</td>
          <td>
            <a href="{{ route('municipalities.show',$mun) }}" class="btn">Ver</a>
            <a href="{{ route('municipalities.edit',$mun) }}" class="btn">Editar</a>
            <form action="{{ route('municipalities.destroy',$mun) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar municipio?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5">No hay municipios creados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
