@extends('layouts.app')
@section('title','Crear Rol')

@section('content')
  <h1>Crear Rol</h1>
  <form action="{{ route('roles.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="RoleId">ID del Rol</label>
      <input type="text" name="RoleId" id="RoleId" maxlength="450" required>
    </div>
    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" maxlength="256">
    </div>
    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
