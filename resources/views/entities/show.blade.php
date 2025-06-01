@extends('layouts.app')

@section('title','Detalle de Entidad')

@section('content')
  <h1>Detalle de Entidad</h1>
  <p><strong>ID:</strong> {{ $entity->EntityId }}</p>
  <p><strong>País:</strong> {{ optional($entity->country)->Name }}</p>
  <p><strong>Nombre:</strong> {{ $entity->Name }}</p>
  <p><strong>Status:</strong> {{ $entity->Status ? 'Activo' : 'Inactivo' }}</p>
  <a href="{{ route('entities.index') }}" class="btn">Volver</a>
@endsection
