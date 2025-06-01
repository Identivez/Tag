@extends('layouts.app')

@section('title','Crear Reseña')

@section('content')
  <h1>Crear Reseña</h1>
  <form action="{{ route('reviews.store') }}" method="POST">
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
      <label for="UserId">Usuario</label>
      <select name="UserId" id="UserId" required>
        @foreach($users as $id => $name)
          <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="Rating">Calificación (1–5)</label>
      <input type="number" name="Rating" id="Rating" min="1" max="5">
    </div>

    <div class="form-group">
      <label for="Comment">Comentario</label>
      <textarea name="Comment" id="Comment"></textarea>
    </div>

    <div class="form-group">
      <label for="ReviewDate">Fecha de Reseña</label>
      <input type="datetime-local" name="ReviewDate" id="ReviewDate">
    </div>

    <button type="submit" class="btn">Guardar</button>
  </form>
@endsection
