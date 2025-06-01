@extends('layouts.app')
@section('title','Crear Entidad')

@section('content')
  <h1>Crear Entidad</h1>
  <form action="{{ route('entities.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="CountryId">País</label>
      <select name="CountryId" id="CountryId" required>
        <option value="">-- Selecciona un país --</option>
        @foreach($countries as $pais)
          <option value="{{ $pais->CountryId }}">{{ $pais->Name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" maxlength="256" required>
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
