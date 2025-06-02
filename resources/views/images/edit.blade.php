@extends('layouts.app')

@section('title','Editar Imagen')

@section('content')
  <h1>Editar Imagen</h1>

  @if ($errors->any())
    <div style="color: red">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('images.update', $image) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-group">
      <label>ID Imagen</label>
      <input type="text" value="{{ $image->ImageId }}" readonly>
    </div>

    <div class="form-group">
      <label>Producto</label>
      <input type="text" value="{{ $image->product->Name }}" readonly>
    </div>

    <div class="form-group">
      <label>Archivo Actual</label><br>
      @php
        $isPdf = \Illuminate\Support\Str::endsWith($image->ImageFileName, '.pdf');
      @endphp

      @if ($isPdf)
        📄 <a href="{{ asset('storage/' . $image->ImageFileName) }}" target="_blank">Ver PDF</a>
      @else
        <img src="{{ asset('storage/' . $image->ImageFileName) }}" alt="Imagen actual" width="150"><br>
        <a href="{{ asset('storage/' . $image->ImageFileName) }}" target="_blank">Ver imagen</a>
      @endif

      <br><a href="{{ asset('storage/' . $image->ImageFileName) }}" download>Descargar archivo</a>
    </div>

    <div class="form-group">
      <label for="image">Subir nuevo archivo (opcional)</label>
      <input type="file" name="image" accept="image/*,application/pdf">
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
