@extends('layouts.app')

@section('title','Detalle de Reseña')

@section('content')
  <h1>Detalle de Reseña</h1>
  <p><strong>ID:</strong> {{ $review->ReviewId }}</p>
  <p><strong>Producto:</strong> {{ optional($review->product)->Name }}</p>
  <p>
    <strong>Usuario:</strong>
    {{ optional($review->user)->firstName }}
    {{ optional($review->user)->lastName }}
  </p>
  <p><strong>Calificación:</strong> {{ $review->Rating }}</p>
  <p><strong>Comentario:</strong> {{ $review->Comment }}</p>
  <p><strong>Fecha de Reseña:</strong> {{ optional($review->ReviewDate)->format('d/m/Y H:i') }}</p>
  <a href="{{ route('reviews.index') }}" class="btn">Volver</a>
@endsection
