@extends('layouts.app')

@section('title', 'Gráfica de Cantidades')

@section('content')
<div class="container">
    <h2>Cantidad inicial por producto</h2>
    <div id="grafica-cantidades" style="height: 400px;"></div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
Highcharts.chart('grafica-cantidades', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Cantidad inicial registrada'
    },
    xAxis: {
        categories: {!! json_encode($productos->pluck('Name')) !!}
    },
    yAxis: {
        title: {
            text: 'Cantidad'
        }
    },
    series: [{
        name: 'Cantidad',
        data: {!! json_encode($productos->pluck('Quantity')->map(fn($q) => (int)$q)) !!}
    }]
});
</script>
@endsection
