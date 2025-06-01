@extends('layouts.app')

@section('title','Editar Talla')

@section('content')
  <h1>Editar Talla</h1>
  <form action="{{ route('sizes.update', $size) }}" method="POST">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label for="SizeValue">Valor</label>
      <input
        type="text"
        name="SizeValue"
        id="SizeValue"
        value="{{ $size->SizeValue }}"
        maxlength="10"
        required
      >
    </div>

    <div class="form-group">
      <label for="SizeRegion">Región</label>
      <input
        type="text"
        name="SizeRegion"
        id="SizeRegion"
        value="{{ $size->SizeRegion }}"
        maxlength="5"
        required
      >
    </div>

    <div class="form-group">
      <label for="SizeType">Tipo</label>
      <input
        type="text"
        name="SizeType"
        id="SizeType"
        value="{{ $size->SizeType }}"
        maxlength="10"
        required
      >
    </div>

    <div class="form-group">
      <label for="IsActive">Activo</label>
      <select name="IsActive" id="IsActive">
        <option value="1" {{ $size->IsActive ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$size->IsActive ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
