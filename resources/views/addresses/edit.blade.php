@extends('layouts.app')

@section('title','Editar Dirección')

@section('content')
  <h1>Editar Dirección</h1>
  <form action="{{ route('addresses.update', $address) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID</label>
      <input type="text" value="{{ $address->AddressId }}" readonly>
    </div>

    <div class="form-group">
      <label for="AddressLine1">Dirección Línea 1</label>
      <textarea name="AddressLine1" id="AddressLine1" required>{{ $address->AddressLine1 }}</textarea>
    </div>

    <div class="form-group">
      <label for="AddressLine2">Dirección Línea 2</label>
      <textarea name="AddressLine2" id="AddressLine2">{{ $address->AddressLine2 }}</textarea>
    </div>

    <div class="form-group">
      <label for="City">Ciudad</label>
      <input type="text" name="City" id="City" value="{{ $address->City }}" required>
    </div>

    <div class="form-group">
      <label for="State">Estado</label>
      <input type="text" name="State" id="State" value="{{ $address->State }}" required>
    </div>

    <div class="form-group">
      <label for="ZipCode">Código Postal</label>
      <input type="number" name="ZipCode" id="ZipCode" value="{{ $address->ZipCode }}">
    </div>

    <div class="form-group">
      <label for="Country">País (texto)</label>
      <input type="text" name="Country" id="Country" value="{{ $address->Country }}" required>
    </div>

    <div class="form-group">
      <label for="CountryId">País (vínculo)</label>
      <select name="CountryId" id="CountryId">
        <option value="">— Ninguno —</option>
        @foreach($countries as $id => $name)
          <option value="{{ $id }}" {{ $address->CountryId == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="MunicipalityId">Municipio</label>
      <select name="MunicipalityId" id="MunicipalityId">
        <option value="">— Ninguno —</option>
        @foreach($municipalities as $id => $name)
          <option value="{{ $id }}" {{ $address->MunicipalityId == $id ? 'selected' : '' }}>{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="AddressType">Tipo de Dirección</label>
      <input type="text" name="AddressType" id="AddressType" value="{{ $address->AddressType }}" maxlength="50" required>
    </div>

    <div class="form-group">
      <label for="IsDefault">Predeterminada</label>
      <select name="IsDefault" id="IsDefault">
        <option value="1" {{ $address->IsDefault ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$address->IsDefault ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <div class="form-group">
      <label for="IsActive">Activo</label>
      <select name="IsActive" id="IsActive">
        <option value="1" {{ $address->IsActive ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$address->IsActive ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
