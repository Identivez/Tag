@extends('layouts.app')

@section('title','Detalle de Producto')

@section('content')
  <h1>Detalle de Producto</h1>
  <p><strong>ID:</strong> {{ $product->ProductId }}</p>
  <p><strong>Nombre:</strong> {{ $product->Name }}</p>
  <p><strong>Marca:</strong> {{ $product->Brand }}</p>
  <p><strong>Precio:</strong> {{ number_format($product->Price,2) }}</p>
  <p><strong>Descripción:</strong> {{ $product->Description }}</p>
  <p><strong>Cantidad:</strong> {{ $product->Quantity }}</p>
  <p><strong>Stock:</strong> {{ $product->Stock }}</p>
  <p><strong>Proveedor:</strong> {{ optional($product->provider)->Name }}</p>
  <p><strong>Categoría:</strong> {{ optional($product->category)->Name }}</p>
  <p><strong>Creado:</strong> {{ $product->CreatedAt?->format('d/m/Y H:i') }}</p>
  <p><strong>Última actualización:</strong> {{ $product->LastUpdate?->format('d/m/Y H:i') }}</p>
  <a href="{{ route('products.index') }}" class="btn">Volver</a>
@endsection
