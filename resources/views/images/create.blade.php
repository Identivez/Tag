@extends('layouts.app')

@section('title','Subir Imagen de Producto')

@section('content')
  <h1>Subir Imagen de Producto</h1>

  @if(session('success'))
    <div style="color: green">{{ session('success') }}</div>
  @endif

  @if ($errors->any())
    <div style="color: red">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
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
      <label for="image">Seleccionar Archivo (imagen o PDF)</label>
      <input type="file" name="image" id="image" accept="image/*,application/pdf" required>
    </div>

    <button type="submit" class="btn">Subir</button>
  </form>
@endsection
