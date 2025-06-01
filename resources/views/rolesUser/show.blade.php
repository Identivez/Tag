@extends('layouts.app')

@section('title','Detalle de Rol')

@section('content')
  <h1>Detalle de Rol</h1>
  <p><strong>ID Rol:</strong> {{ $role->RoleId }}</p>
  <p><strong>Nombre:</strong> {{ $role->Name }}</p>
  <a href="{{ route('roles.index') }}" class="btn">Volver</a>
@endsection
