@extends('layouts.app')
@section('title','Detalle de Municipio')

@section('content')
  <h1>Detalle de Municipio</h1>

  <p><strong>ID:</strong> {{ $municipality->MunId }}</p>
  <p><strong>Entidad:</strong> {{ $municipality->entity->Name }}</p>
  <p><strong>Nombre:</strong> {{ $municipality->Name }}</p>
  <p><strong>Status:</strong> {{ $municipality->Status ? 'Activo':'Inactivo' }}</p>

  <a href="{{ route('municipalities.index') }}" class="btn">Volver</a>
@endsection
