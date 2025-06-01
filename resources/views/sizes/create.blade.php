@extends('layouts.app')

@section('title','Crear Talla')

@section('content')
  <h1>Crear Talla</h1>
  <form action="{{ route('sizes.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="SizeValue">Valor</label>
      <input type="text" name="SizeValue" id="SizeValue" maxlength="10" required>
    </div>

    <div class="form-group">
      <label for="SizeRegion">Región</label>
      <input type="text" name="SizeRegion" id="SizeRegion" maxlength="5" required>
    </div>

    <div class="form-group">
      <label for="SizeType">Tipo</label>
      <input type="text" name="SizeType" id="SizeType" maxlength="10" required>
    </div>

    <div class="form-group">
      <label for="IsActive">Activo</label>
      <select name="IsActive" id="IsActive">
        <option value="1">Sí</option>
        <option value="0">No</option>
      </select>
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
