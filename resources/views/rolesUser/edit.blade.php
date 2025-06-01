@extends('layouts.app')

@section('title','Editar Rol')

@section('content')
  <h1>Editar Rol</h1>
  <form action="{{ route('roles.update', $role) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label for="RoleId">ID Rol</label>
      <input type="text" name="RoleId" id="RoleId" value="{{ $role->RoleId }}" readonly>
    </div>

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" value="{{ $role->Name }}" maxlength="256">
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
