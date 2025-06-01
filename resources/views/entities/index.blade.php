@extends('layouts.app')
@section('title','Listado de Entidades')

@section('content')
  <h1>Entidades</h1>
  <a href="{{ route('entities.create') }}" class="btn">Crear Entidad</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>País</th>
        <th>Nombre</th>
        <th>Status</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($entities as $entity)
        <tr>
          <td>{{ $entity->EntityId }}</td>
          <td>{{ $entity->country->Name }}</td>
          <td>{{ $entity->Name }}</td>
          <td>{{ $entity->Status ? 'Activo' : 'Inactivo' }}</td>
          <td>
            <a href="{{ route('entities.show',$entity) }}" class="btn">Ver</a>
            <a href="{{ route('entities.edit',$entity) }}" class="btn">Editar</a>
            <form action="{{ route('entities.destroy',$entity) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar entidad?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="5">No hay entidades creadas.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
@endsection
