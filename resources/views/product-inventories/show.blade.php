@extends('layouts.app')

@section('title','Detalle de Inventario')

@section('content')
  <h1>Detalle de Inventario</h1>
  <p><strong>ID:</strong> {{ $productInventory->InventoryId }}</p>
  <p><strong>Producto:</strong> {{ $productInventory->product->Name }}</p>
  <p><strong>Talla:</strong> {{ $productInventory->size->SizeValue }} ({{ $productInventory->size->SizeRegion }}-{{ $productInventory->size->SizeType }})</p>
  <p><strong>Cantidad:</strong> {{ $productInventory->Quantity }}</p>
  <p><strong>Precio:</strong> {{ $productInventory->Price }}</p>
  <p><strong>SKU:</strong> {{ $productInventory->SKU }}</p>
  <p><strong>Condición:</strong> {{ $productInventory->Condition }}</p>
  <p><strong>En Stock:</strong> {{ $productInventory->InStock ? 'Sí' : 'No' }}</p>
  <p><strong>Nivel Reorden:</strong> {{ $productInventory->ReorderLevel }}</p>
  <p><strong>Última Actualización:</strong> {{ $productInventory->LastUpdated }}</p>
  <a href="{{ route('product-inventories.index') }}" class="btn">Volver</a>
@endsection
