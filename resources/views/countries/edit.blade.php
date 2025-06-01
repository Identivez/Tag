@extends('layouts.app')
@section('title','Editar País')

@section('content')
  <h1>Editar País</h1>
  <form action="{{ route('countries.update',$country) }}" method="POST">
    @csrf @method('PATCH')
    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" value="{{ $country->Name }}" required>
    </div>
    <div class="form-group">
      <label for="Key">Key</label>
      <input type="text" name="Key" id="Key" maxlength="5" value="{{ $country->Key }}" required>
    </div>
    <div class="form-group">
      <label for="Status">Status</label>
      <select name="Status" id="Status">
        <option value="1" {{ $country->Status?'selected':'' }}>Activo</option>
        <option value="0" {{ !$country->Status?'selected':'' }}>Inactivo</option>
      </select>
    </div>
    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
