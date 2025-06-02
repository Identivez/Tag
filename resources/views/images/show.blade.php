@extends('layouts.app')

@section('title','Detalle de Imagen')

@section('content')
  <h1>Detalle de Imagen</h1>

  <p><strong>ID:</strong> {{ $image->ImageId }}</p>
  <p><strong>Producto:</strong> {{ $image->product->Name }}</p>

  <div class="form-group">
    <p><strong>Archivo:</strong></p>
    @php
      $isPdf = \Illuminate\Support\Str::endsWith($image->ImageFileName, '.pdf');
    @endphp

    @if ($isPdf)
      📄 <a href="{{ asset('storage/' . $image->ImageFileName) }}" target="_blank">Ver PDF</a>
    @else
      <img src="{{ asset('storage/' . $image->ImageFileName) }}" alt="Imagen" width="200"><br>
      <a href="{{ asset('storage/' . $image->ImageFileName) }}" target="_blank">Ver imagen</a>
    @endif

    <br>
    <a href="{{ asset('storage/' . $image->ImageFileName) }}" download>Descargar archivo</a>
  </div>

  <a href="{{ route('images.index') }}" class="btn">Volver</a>
@endsection
