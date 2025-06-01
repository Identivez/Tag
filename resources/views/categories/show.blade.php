@extends('layouts.app')

@section('title','Detalle de Categoría')

@section('content')
  <h1>Detalle de Categoría</h1>
  <p><strong>ID:</strong> {{ $category->CategoryId }}</p>
  <p><strong>Nombre:</strong> {{ $category->Name }}</p>
  <p><strong>Descripción:</strong> {{ $category->Description }}</p>
  <p>
    <strong>Creado:</strong>
    {{ optional($category->created_at)->format('d/m/Y H:i') }}
  </p>
  <p>
    <strong>Actualizado:</strong>
    {{ optional($category->updated_at)->format('d/m/Y H:i') }}
  </p>
  <a href="{{ route('categories.index') }}" class="btn">Volver</a>
@endsection
