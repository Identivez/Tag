@extends('layouts.app')
@section('title','Listado de Usuarios')

@section('content')
  <h1>Usuarios</h1>
  <a href="{{ route('users.create') }}" class="btn">Crear Usuario</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Municipio</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($users as $u)
        <tr>
          <td>{{ $u->UserId }}</td>
          <td>{{ $u->firstName }} {{ $u->lastName }}</td>
          <td>{{ $u->email }}</td>
          <td>{{ $u->municipality?->Name ?? '—' }}</td>
          <td>
            <a href="{{ route('users.show',$u) }}" class="btn">Ver</a>
            <a href="{{ route('users.edit',$u) }}" class="btn">Editar</a>
            <form action="{{ route('users.destroy',$u) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar usuario?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="5">No hay usuarios.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
