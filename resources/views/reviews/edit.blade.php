@extends('layouts.app')

@section('title','Editar Reseña')

@section('content')
  <h1>Editar Reseña</h1>
  <form action="{{ route('reviews.update', $review) }}" method="POST">
    @csrf @method('PATCH')

    <div class="form-group">
      <label>ID Reseña</label>
      <input type="text" value="{{ $review->ReviewId }}" readonly>
    </div>

    <div class="form-group">
      <label>Producto</label>
      <input type="text" value="{{ $review->product->Name }}" readonly>
    </div>

    <div class="form-group">
      <label>Usuario</label>
      <input
        type="text"
        value="{{ optional($review->user)->firstName }} {{ optional($review->user)->lastName }}"
        readonly
      >
    </div>

    <div class="form-group">
      <label for="Rating">Calificación (1–5)</label>
      <input
        type="number"
        name="Rating"
        id="Rating"
        value="{{ $review->Rating }}"
        min="1"
        max="5"
      >
    </div>

    <div class="form-group">
      <label for="Comment">Comentario</label>
      <textarea name="Comment" id="Comment">{{ $review->Comment }}</textarea>
    </div>

    <div class="form-group">
      <label for="ReviewDate">Fecha de Reseña</label>
      <input
        type="datetime-local"
        name="ReviewDate"
        id="ReviewDate"
        value="{{ optional($review->ReviewDate)->format('Y-m-d\TH:i') }}"
      >
    </div>

    <button type="submit" class="btn">Actualizar</button>
  </form>
@endsection
