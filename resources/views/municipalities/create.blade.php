@extends('layouts.app')
@section('title','Crear Municipio')

@section('content')
  <h1>Crear Municipio</h1>
  <form action="{{ route('municipalities.store') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="EntityId">Entidad</label>
      <select name="EntityId" id="EntityId" required>
        <option value="">-- Selecciona una entidad --</option>
        @foreach($entities as $ent)
          <option value="{{ $ent->EntityId }}">{{ $ent->Name }}</option>
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
