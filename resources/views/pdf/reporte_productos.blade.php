<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Productos - TAG & SOLE</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #28a745;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #28a745;
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .header .subtitle {
            color: #666;
            font-size: 16px;
            margin: 5px 0;
        }

        .header .store-name {
            color: #28a745;
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .report-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #28a745;
        }

        .report-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th {
            background-color: #28a745;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #28a745;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            background-color: white;
        }

        tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .price {
            text-align: right;
            font-weight: bold;
            color: #28a745;
        }

        .stock {
            text-align: center;
            font-weight: bold;
        }

        .stock.low {
            color: #dc3545;
            background-color: #f8d7da;
        }

        .stock.medium {
            color: #856404;
            background-color: #fff3cd;
        }

        .stock.high {
            color: #155724;
            background-color: #d4edda;
        }

        .category {
            text-align: center;
            font-style: italic;
        }

        .summary {
            background-color: #e8f5e8;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
            border: 1px solid #28a745;
        }

        .summary h4 {
            color: #28a745;
            margin-top: 0;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 15px;
        }

        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #666;
            background-color: #fff3cd;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TAG & SOLE</h1>
        <div class="store-name">Sneakers & Moda Urbana</div>
        <div class="subtitle">Reporte General de Productos</div>
    </div>

    <!-- Información del Reporte -->
    <div class="report-info">
        <p><strong>Fecha de generación:</strong> {{ $date->format('d/m/Y H:i:s') }}</p>
        <p><strong>Tipo de reporte:</strong> Listado completo de productos</p>
        <p><strong>Sistema:</strong> TAG & SOLE - Panel de Administración</p>
        <p><strong>Total de productos:</strong> {{ count($productos) }}</p>
    </div>

    <!-- Tabla de Productos -->
    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Producto</th>
                <th style="width: 15%;">Precio</th>
                <th style="width: 15%;">Stock</th>
                <th style="width: 20%;">Categoría</th>
                <th style="width: 10%;">Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $prod)
            <tr>
                <td>
                    <strong>{{ $prod->Name }}</strong>
                    @if($prod->Brand)
                        <br><small>Marca: {{ $prod->Brand }}</small>
                    @endif
                </td>
                <td class="price">${{ number_format($prod->Price, 2) }}</td>
                <td class="stock {{ $prod->Stock <= 5 ? 'low' : ($prod->Stock <= 20 ? 'medium' : 'high') }}">
                    {{ $prod->Stock }}
                    @if($prod->Stock <= 5)
                        <br><small>(BAJO)</small>
                    @elseif($prod->Stock <= 20)
                        <br><small>(MEDIO)</small>
                    @else
                        <br><small>(ALTO)</small>
                    @endif
                </td>
                <td class="category">{{ $prod->category->Name ?? 'Sin categoría' }}</td>
                <td style="text-align: center;">
                    @if($prod->Stock > 0)
                        <span style="color: #28a745; font-weight: bold;">ACTIVO</span>
                    @else
                        <span style="color: #dc3545; font-weight: bold;">AGOTADO</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">
                    No hay productos registrados en el sistema
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Resumen -->
    <div class="summary">
        <h4>Resumen del Inventario</h4>
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Productos Activos</strong><br>
                {{ collect($productos)->where('Stock', '>', 0)->count() }}
            </div>
            <div class="summary-item">
                <strong>Productos Agotados</strong><br>
                {{ collect($productos)->where('Stock', '<=', 0)->count() }}
            </div>
            <div class="summary-item">
                <strong>Stock Bajo (≤5)</strong><br>
                {{ collect($productos)->where('Stock', '<=', 5)->where('Stock', '>', 0)->count() }}
            </div>
            <div class="summary-item">
                <strong>Valor Total Inventario</strong><br>
                ${{ number_format(collect($productos)->sum(function($p) { return $p->Price * $p->Stock; }), 2) }}
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>TAG & SOLE</strong> - Sistema de Gestión de Inventario</p>
        <p>Centro Comercial Galerías Toluca | +52 722 123 4567 | info@tagsole.com</p>
        <p>Reporte generado automáticamente el {{ now()->format('d/m/Y \a \l\a\s H:i:s') }}</p>
    </div>
</body>
</html>
