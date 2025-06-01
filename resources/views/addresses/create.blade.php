@extends('layouts.app')

@section('title','Crear Dirección')

@section('content')
  <h1>Crear Dirección</h1>
  <form action="{{ route('addresses.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="UserId">Usuario</label>
      <select name="UserId" id="UserId" required>
        @foreach($users as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="AddressLine1">Dirección Línea 1</label>
      <textarea name="AddressLine1" id="AddressLine1" required></textarea>
    </div>

    <div class="form-group">
      <label for="AddressLine2">Dirección Línea 2</label>
      <textarea name="AddressLine2" id="AddressLine2"></textarea>
    </div>

    <div class="form-group">
      <label for="City">Ciudad</label>
      <input type="text" name="City" id="City" required>
    </div>

    <div class="form-group">
      <label for="State">Estado</label>
      <input type="text" name="State" id="State" required>
    </div>

    <div class="form-group">
      <label for="ZipCode">Código Postal</label>
      <input type="number" name="ZipCode" id="ZipCode">
    </div>

    <div class="form-group">
      <label for="Country">País (texto)</label>
      <input type="text" name="Country" id="Country" required>
    </div>

    <div class="form-group">
      <label for="CountryId">País (vínculo)</label>
      <select name="CountryId" id="CountryId">
        <option value="">— Ninguno —</option>
        @foreach($countries as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="MunicipalityId">Municipio</label>
      <select name="MunicipalityId" id="MunicipalityId">
        <option value="">— Ninguno —</option>
        @foreach($municipalities as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="AddressType">Tipo de Dirección</label>
      <input type="text" name="AddressType" id="AddressType" maxlength="50" required>
    </div>

    <div class="form-group">
      <label for="IsDefault">Predeterminada</label>
      <select name="IsDefault" id="IsDefault">
        <option value="1">Sí</option>
        <option value="0">No</option>
      </select>
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
