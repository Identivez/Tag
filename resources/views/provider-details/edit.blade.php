@extends('layouts.app')

@section('title','Editar Detalle de Proveedor')

@section('content')
  <h1>Editar Detalle de Proveedor</h1>
  <form action="{{ route('provider-details.update', $providerDetail) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Detalle</label>
      <input type="text" value="{{ $providerDetail->ProviderDetailsId }}" readonly>
    </div>

    <div class="form-group">
      <label>Proveedor</label>
      <input type="text" value="{{ $providerDetail->provider->Name }}" readonly>
    </div>

    <div class="form-group">
      <label>Producto</label>
      <input type="text" value="{{ $providerDetail->product->Name }}" readonly>
    </div>

    <div class="form-group">
      <label for="Price">Precio</label>
      <input
        type="text"
        name="Price"
        id="Price"
        value="{{ $providerDetail->Price }}"
      >
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input
        type="number"
        name="Quantity"
        id="Quantity"
        value="{{ $providerDetail->Quantity }}"
        min="0"
      >
    </div>

    <div class="form-group">
      <label for="SupplyDate">Fecha de Suministro</label>
      <input
        type="date"
        name="SupplyDate"
        id="SupplyDate"
        value="{{ optional($providerDetail->SupplyDate)->format('Y-m-d') }}"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
