@extends('layouts.app')

@section('title','Editar Inventario de Producto')

@section('content')
  <h1>Editar Inventario</h1>
  <form action="{{ route('product-inventories.update', $productInventory) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label for="InventoryId">ID Inventario</label>
      <input type="text" id="InventoryId" value="{{ $productInventory->InventoryId }}" readonly>
    </div>

    <div class="form-group">
      <label for="ProductId">Producto</label>
      <select name="ProductId" id="ProductId" required>
        @foreach($products as $id => $name)
          <option value="{{ $id }}" {{ $productInventory->ProductId == $id ? 'selected' : '' }}>
            {{ $name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="SizeId">Talla</label>
      <select name="SizeId" id="SizeId" required>
        @foreach($sizes as $id => $label)
          <option value="{{ $id }}" {{ $productInventory->SizeId == $id ? 'selected' : '' }}>
            {{ $label }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="Quantity">Cantidad</label>
      <input
        type="number"
        name="Quantity"
        id="Quantity"
        value="{{ $productInventory->Quantity }}"
        min="0"
        required
      >
    </div>

    <div class="form-group">
      <label for="Price">Precio</label>
      <input
        type="text"
        name="Price"
        id="Price"
        value="{{ $productInventory->Price }}"
      >
    </div>

    <div class="form-group">
      <label for="SKU">SKU</label>
      <input
        type="text"
        name="SKU"
        id="SKU"
        value="{{ $productInventory->SKU }}"
        maxlength="50"
      >
    </div>

    <div class="form-group">
      <label for="Condition">Condición</label>
      <input
        type="text"
        name="Condition"
        id="Condition"
        value="{{ $productInventory->Condition }}"
        maxlength="20"
        required
      >
    </div>

    <div class="form-group">
      <label for="InStock">En stock</label>
      <select name="InStock" id="InStock">
        <option value="1" {{ $productInventory->InStock ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$productInventory->InStock ? 'selected' : '' }}>No</option>
      </select>
    </div>

    <div class="form-group">
      <label for="ReorderLevel">Nivel de Reorden</label>
      <input
        type="number"
        name="ReorderLevel"
        id="ReorderLevel"
        value="{{ $productInventory->ReorderLevel }}"
        min="0"
        required
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
