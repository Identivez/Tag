@extends('layouts.app')

@section('title','Crear Proveedor')

@section('content')
  <h1>Crear Proveedor</h1>
  <form action="{{ route('providers.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input type="text" name="Name" id="Name" maxlength="255">
    </div>

    <div class="form-group">
      <label for="ContactEmail">Email de Contacto</label>
      <input type="email" name="ContactEmail" id="ContactEmail" maxlength="256">
    </div>

    <div class="form-group">
      <label for="ContactPhone">Teléfono de Contacto</label>
      <input type="text" name="ContactPhone" id="ContactPhone" maxlength="20">
    </div>

    <div class="form-group">
      <label for="Address">Dirección</label>
      <textarea name="Address" id="Address"></textarea>
    </div>

    <div class="form-group">
      <label for="ContactName">Nombre de Contacto</label>
      <input type="text" name="ContactName" id="ContactName" maxlength="256">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
