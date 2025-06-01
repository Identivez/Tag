@extends('layouts.app')

@section('title','Editar Proveedor')

@section('content')
  <h1>Editar Proveedor</h1>
  <form action="{{ route('providers.update', $provider) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label for="ProviderId">ID Proveedor</label>
      <input type="text" id="ProviderId" value="{{ $provider->ProviderId }}" readonly>
    </div>

    <div class="form-group">
      <label for="Name">Nombre</label>
      <input
        type="text"
        name="Name"
        id="Name"
        value="{{ $provider->Name }}"
        maxlength="255"
      >
    </div>

    <div class="form-group">
      <label for="ContactEmail">Email de Contacto</label>
      <input
        type="email"
        name="ContactEmail"
        id="ContactEmail"
        value="{{ $provider->ContactEmail }}"
        maxlength="256"
      >
    </div>

    <div class="form-group">
      <label for="ContactPhone">Teléfono de Contacto</label>
      <input
        type="text"
        name="ContactPhone"
        id="ContactPhone"
        value="{{ $provider->ContactPhone }}"
        maxlength="20"
      >
    </div>

    <div class="form-group">
      <label for="Address">Dirección</label>
      <textarea name="Address" id="Address">{{ $provider->Address }}</textarea>
    </div>

    <div class="form-group">
      <label for="ContactName">Nombre de Contacto</label>
      <input
        type="text"
        name="ContactName"
        id="ContactName"
        value="{{ $provider->ContactName }}"
        maxlength="256"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
