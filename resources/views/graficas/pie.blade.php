@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Inventario por producto (pastel)</h2>
    <div id="grafica" style="height: 400px;"></div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script>
Highcharts.chart('grafica', {
    chart: {
        type: 'pie'
    },
    title: {
        text: 'Distribución de Inventario'
    },
    series: [{
        name: 'Stock',
        colorByPoint: true,
        data: [
            @foreach($productos as $prod)
                { name: "{{ $prod->Name }}", y: {{ $prod->Stock }} },
            @endforeach
        ]
    }]
});
</script>
@endsection
