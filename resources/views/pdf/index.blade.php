@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reportes PDF') }}</div>

                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('pdf.products', 1) }}" class="list-group-item list-group-item-action">
                            Ver reporte de productos
                        </a>
                        <a href="{{ route('pdf.products', 2) }}" class="list-group-item list-group-item-action">
                            Descargar reporte de productos
                        </a>

                        @if(auth()->check() && auth()->user()->orders->count() > 0)
                            <h5 class="mt-4">Facturas de pedidos</h5>
                            @foreach(auth()->user()->orders as $order)
                                <a href="{{ route('pdf.invoice', [1, $order->OrderId]) }}" class="list-group-item list-group-item-action">
                                    Ver factura del pedido #{{ $order->OrderId }} - {{ $order->OrderDate->format('d/m/Y') }}
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
