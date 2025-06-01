@extends('layouts.app')

@section('title','Detalle de Talla')

@section('content')
  <h1>Detalle de Talla</h1>
  <p><strong>ID:</strong> {{ $size->SizeId }}</p>
  <p><strong>Valor:</strong> {{ $size->SizeValue }}</p>
  <p><strong>Región:</strong> {{ $size->SizeRegion }}</p>
  <p><strong>Tipo:</strong> {{ $size->SizeType }}</p>
  <p><strong>Activo:</strong> {{ $size->IsActive ? 'Sí' : 'No' }}</p>
  <a href="{{ route('sizes.index') }}" class="btn">Volver</a>
@endsection
