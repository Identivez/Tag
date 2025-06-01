@extends('layouts.app')
@section('title','Editar Municipio')

@section('content')
  <h1>Editar Municipio</h1>
  <form action="{{ route('municipalities.update',$municipality) }}" method="POST">
    @csrf @method('PATCH')
    <div class="form-group">
      <label for="EntityId">Entidad</label>
      <select name="EntityId" id="EntityId" required>
        @foreach($entities as $ent)
          <option value="{{ $ent->EntityId }}"
            {{ $municipality->EntityId == $ent->EntityId ? 'selected':'' }}>
            {{ $ent->Name }}
          </option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name"
             value="{{ $municipality->Name }}" maxlength="256" required>
    </div>
    <div class="form-group">
      <label for="Status">Status</label>
      <select name="Status" id="Status">
        <option value="1" {{ $municipality->Status?'selected':'' }}>Activo</option>
        <option value="0" {{ !$municipality->Status?'selected':'' }}>Inactivo</option>
      </select>
    </div>
    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
