@extends('layouts.app')

@section('title','Listado de Direcciones')

@section('content')
  <h1>Direcciones</h1>
  <a href="{{ route('addresses.create') }}" class="btn">Crear Dirección</a>

  <table class="table-crud">
    <thead>
      <tr>
        <th>ID</th>
        <th>Usuario</th>
        <th>Dirección</th>
        <th>Ciudad</th>
        <th>Estado</th>
        <th>País</th>
        <th>Municipio</th>
        <th>Tipo</th>
        <th>Predet.</th>
        <th>Activo</th>
        <th>Creado</th>
        <th>Actualizado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      @forelse($addresses as $addr)
        <tr>
          <td>{{ $addr->AddressId }}</td>
          <td>{{ $addr->user->name }}</td>
          <td>{{ \Illuminate\Support\Str::limit($addr->AddressLine1,30) }}</td>
          <td>{{ $addr->City }}</td>
          <td>{{ $addr->State }}</td>
          <td>{{ optional($addr->country)->Name ?? $addr->Country }}</td>
          <td>{{ optional($addr->municipality)->Name }}</td>
          <td>{{ $addr->AddressType }}</td>
          <td>{{ $addr->IsDefault ? 'Sí' : 'No' }}</td>
          <td>{{ $addr->IsActive ? 'Sí' : 'No' }}</td>
          <td>{{ $addr->CreatedAt }}</td>
          <td>{{ $addr->UpdatedAt }}</td>
          <td>
            <a href="{{ route('addresses.show', $addr) }}" class="btn">Ver</a>
            <a href="{{ route('addresses.edit', $addr) }}" class="btn">Editar</a>
            <form action="{{ route('addresses.destroy', $addr) }}" method="POST" style="display:inline">
              @csrf @method('DELETE')
              <button type="submit" class="btn" onclick="return confirm('¿Eliminar dirección?')">Eliminar</button>
            </form>
          </td>
        </tr>
      @empty
        <tr><td colspan="13">No hay direcciones registradas.</td></tr>
      @endforelse
    </tbody>
  </table>
@endsection
