@extends('layouts.app')

@section('title','Detalle de Imagen')

@section('content')
  <h1>Detalle de Imagen</h1>
  <p><strong>ID:</strong> {{ $image->ImageId }}</p>
  <p><strong>Producto:</strong> {{ $image->product->Name }}</p>
  <p><strong>Archivo:</strong> {{ $image->ImageFileName }}</p>
  <a href="{{ route('images.index') }}" class="btn">Volver</a>
@endsection
