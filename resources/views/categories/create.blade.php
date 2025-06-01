@extends('layouts.app')

@section('title','Crear Categoría')

@section('content')
  <h1>Crear Categoría</h1>
  <form action="{{ route('categories.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" maxlength="255" required>
    </div>

    <div class="form-group">
      <label for="Description">Descripción</label>
      <textarea name="Description" id="Description"></textarea>
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
