@extends('layouts.app')

@section('title', 'Gráfica de Precios')

@section('content')
<div class="container">
    <h2>Precios de productos</h2>
    <div id="grafica-precios" style="height: 400px;"></div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
Highcharts.chart('grafica-precios', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Precio de Productos'
    },
    xAxis: {
        categories: {!! json_encode($productos->pluck('Name')) !!},
        title: { text: 'Producto' }
    },
    yAxis: {
        title: { text: 'Precio (MXN)' }
    },
    series: [{
        name: 'Precio',
        data: {!! json_encode($productos->pluck('Price')->map(fn($p) => floatval($p))) !!}
    }]
});
</script>
@endsection
