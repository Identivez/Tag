@extends('layouts.app')

@section('title', 'Gráficas')

@section('content')
    <div class="container">
        <h1 class="mb-4">Gráficas del Sistema</h1>
        <ul>
            <li><a href="{{ route('graficas.barras') }}">Gráfica de Barras (Precio de Productos)</a></li>
            <li><a href="{{ route('graficas.pie') }}">Gráfica de Pastel (Inventario por Producto)</a></li>
            <li><a href="{{ route('graficas.columnas') }}">Gráfica de Columnas (Ventas por Producto)</a></li>
        </ul>
    </div>
@endsection
