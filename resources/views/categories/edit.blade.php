@extends('layouts.app')

@section('title','Editar Categoría')

@section('content')
  <h1>Editar Categoría</h1>
  <form action="{{ route('categories.update', $category) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input
        type="text"
        name="Name"
        id="Name"
        value="{{ $category->Name }}"
        maxlength="255"
        required
      >
    </div>

    <div class="form-group">
      <label for="Description">Descripción</label>
      <textarea name="Description" id="Description">{{ $category->Description }}</textarea>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
