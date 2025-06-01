@extends('layouts.app')

@section('title','Crear Detalle de Proveedor')

@section('content')
  <h1>Crear Detalle de Proveedor</h1>
  <form action="{{ route('provider-details.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="ProviderId">Proveedor</label>
      <select name="ProviderId" id="ProviderId" required>
        @foreach($providers as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="ProductId">Producto</label>
      <select name="ProductId" id="ProductId" required>
        @foreach($products as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="Price">Precio</label>
      <input type="text" name="Price" id="Price">
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input type="number" name="Quantity" id="Quantity" min="0">
    </div>

    <div class="form-group">
      <label for="SupplyDate">Fecha de Suministro</label>
      <input type="date" name="SupplyDate" id="SupplyDate">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
