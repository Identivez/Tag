@extends('layouts.app')

@section('title','Crear País')

@section('content')
  <h1>Crear País</h1>
  <form action="{{ route('countries.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" required>
    </div>
    <div class="form-group">
      <label for="Key">Key</label>
      <input type="text" name="Key" id="Key" maxlength="5" required>
    </div>
    <div class="form-group">
      <label for="Status">Status</label>
      <select name="Status" id="Status">
        <option value="1">Activo</option>
        <option value="0">Inactivo</option>
      </select>
    </div>
    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
