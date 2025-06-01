@extends('layouts.app')
@section('title','Editar Usuario')

@section('content')
  <h1>Editar Usuario</h1>
  <form action="{{ route('users.update',$user) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label for="UserId">ID del Usuario</label>
      <input type="text" name="UserId" id="UserId"
             value="{{ $user->UserId }}" readonly>
    </div>

    <div class="form-group">
      <label for="firstName">Nombre</label>
      <input type="text" name="firstName" id="firstName"
             value="{{ $user->firstName }}">
    </div>

    <div class="form-group">
      <label for="lastName">Apellido</label>
      <input type="text" name="lastName" id="lastName"
             value="{{ $user->lastName }}">
    </div>

    <div class="form-group">
      <label for="createdAt">Creado en</label>
      <input type="datetime-local" name="createdAt" id="createdAt"
             value="{{ \Carbon\Carbon::parse($user->createdAt)->format('Y-m-d\TH:i') }}">
    </div>

    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" id="email"
             value="{{ $user->email }}" required>
    </div>

    <div class="form-group">
      <label for="password">Contraseña <small>(dejar en blanco para no cambiar)</small></label>
      <input type="password" name="password" id="password">
    </div>

    <div class="form-group">
      <label for="phoneNumber">Teléfono</label>
      <input type="text" name="phoneNumber" id="phoneNumber"
             value="{{ $user->phoneNumber }}">
    </div>

    <div class="form-group">
      <label for="MunicipalityId">Municipio</label>
      <select name="MunicipalityId" id="MunicipalityId">
        <option value="">-- Selecciona un municipio --</option>
        @foreach($municipalities as $m)
          <option value="{{ $m->MunId }}"
            {{ $user->MunicipalityId == $m->MunId ? 'selected':'' }}>
            {{ $m->Name }}
          </option>
        @endforeach
      </select>
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
