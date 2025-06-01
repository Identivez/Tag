@extends('layouts.app')

@section('title','Crear Inventario de Producto')

@section('content')
  <h1>Crear Inventario</h1>
  <form action="{{ route('product-inventories.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="ProductId">Producto</label>
      <select name="ProductId" id="ProductId" required>
        @foreach($products as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="SizeId">Talla</label>
      <select name="SizeId" id="SizeId" required>
        @foreach($sizes as $id => $label)
          <option value="{{ $id }}">{{ $label }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input type="number" name="Quantity" id="Quantity" value="0" min="0" required>
    </div>

    <div class="form-group">
      <label for="Price">Precio</label>
      <input type="text" name="Price" id="Price">
    </div>

    <div class="form-group">
      <label for="SKU">SKU</label>
      <input type="text" name="SKU" id="SKU" maxlength="50">
    </div>

    <div class="form-group">
      <label for="Condition">Condición</label>
      <input type="text" name="Condition" id="Condition" value="New" maxlength="20" required>
    </div>

    <div class="form-group">
      <label for="InStock">En stock</label>
      <select name="InStock" id="InStock">
        <option value="1">Sí</option>
        <option value="0">No</option>
      </select>
    </div>

    <div class="form-group">
      <label for="ReorderLevel">Nivel de Reorden</label>
      <input type="number" name="ReorderLevel" id="ReorderLevel" value="5" min="0" required>
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
