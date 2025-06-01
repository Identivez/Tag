@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 flex flex-col md:flex-row gap-8">
  {{-- Imagen grande --}}
  <div class="flex-1">
    <img src="{{ $product->image_url }}"
         alt="{{ $product->name }}"
         class="w-full rounded-lg object-cover">
  </div>
  {{-- Información --}}
  <div class="flex-1">
    <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
    <p class="text-gray-500 mt-2">${{ number_format($product->price, 2) }}</p>
    <p class="mt-4">{{ $product->description }}</p>
    {{-- Botón Agregar al carrito (más adelante con modal) --}}
    <button class="mt-6 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
      Agregar al carrito
    </button>
  </div>
</div>
@endsection
