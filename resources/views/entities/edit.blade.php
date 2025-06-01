@extends('layouts.app')

@section('title','Editar Entidad')

@section('content')
  <h1>Editar Entidad</h1>
  <form action="{{ route('entities.update', $entity) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="CountryId">País</label>
      <select name="CountryId" id="CountryId" required>
        @foreach($countries as $country)
          <option value="{{ $country->CountryId }}"
            {{ $entity->CountryId == $country->CountryId ? 'selected' : '' }}>
            {{ $country->Name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input
        type="text"
        name="Name"
        id="Name"
        value="{{ $entity->Name }}"
        maxlength="256"
        required
      >
    </div>

    <div class="form-group">
      <label for="Status">Status</label>
      <select name="Status" id="Status">
        <option value="1" {{ $entity->Status ? 'selected' : '' }}>Activo</option>
        <option value="0" {{ !$entity->Status ? 'selected' : '' }}>Inactivo</option>
      </select>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
