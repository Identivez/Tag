@extends('layouts.app')
@section('title','Listado de Roles')

@section('content')
  <h1>Roles</h1>
  <a href="{{ route('roles.create') }}" class="btn">Crear Rol</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($roles as $role)
        <tr>
          <td>{{ $role->RoleId }}</td>
          <td>{{ $role->Name }}</td>
          <td>
            <a href="{{ route('roles.show',$role) }}" class="btn">Ver</a>
            <a href="{{ route('roles.edit',$role) }}" class="btn">Editar</a>
            <form action="{{ route('roles.destroy',$role) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar rol?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="3">No hay roles creados.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
