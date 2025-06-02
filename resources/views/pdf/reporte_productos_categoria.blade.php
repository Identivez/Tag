<!DOCTYPE html>
<html>
<head>
    <title>Productos por Categoría - TAG & SOLE</title>
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

        .category-section {
            margin-bottom: 35px;
            page-break-inside: avoid;
        }

        .category-header {
            background-color: #28a745;
            color: white;
            padding: 12px;
            border-radius: 5px 5px 0 0;
            margin-bottom: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .category-count {
            background-color: rgba(255,255,255,0.2);
            padding: 2px 8px;
            border-radius: 3px;
            font-size: 14px;
            margin-left: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th {
            background-color: #e9ecef;
            color: #495057;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #dee2e6;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            background-color: white;
        }

        tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .no-products {
            text-align: center;
            font-style: italic;
            color: #666;
            background-color: #fff3cd;
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
        }

        .stock.medium {
            color: #ffc107;
        }

        .stock.high {
            color: #28a745;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
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
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TAG & SOLE</h1>
        <div class="store-name">Sneakers & Moda Urbana</div>
        <div class="subtitle">Reporte de Productos por Categoría</div>
    </div>

    <!-- Información del Reporte -->
    <div class="report-info">
        <p><strong>Fecha de generación:</strong> {{ $date->format('d/m/Y H:i:s') }}</p>
        <p><strong>Tipo de reporte:</strong> Productos agrupados por categoría</p>
        <p><strong>Sistema:</strong> TAG & SOLE - Panel de Administración</p>
    </div>

    <!-- Contenido por Categorías -->
    @foreach($categorias as $categoria)
        <div class="category-section">
            <div class="category-header">
                {{ $categoria->Name }}
                <span class="category-count">{{ $categoria->products->count() }} productos</span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th style="width: 40%;">Producto</th>
                        <th style="width: 20%;">Marca</th>
                        <th style="width: 20%;">Precio</th>
                        <th style="width: 20%;">Stock</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categoria->products as $producto)
                    <tr>
                        <td>{{ $producto->Name }}</td>
                        <td>{{ $producto->Brand ?? 'Sin marca' }}</td>
                        <td class="price">${{ number_format($producto->Price, 2) }}</td>
                        <td class="stock {{ $producto->Stock <= 5 ? 'low' : ($producto->Stock <= 20 ? 'medium' : 'high') }}">
                            {{ $producto->Stock }}
                            @if($producto->Stock <= 5)
                                (BAJO)
                            @elseif($producto->Stock <= 20)
                                (MEDIO)
                            @else
                                (ALTO)
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="no-products">
                            Sin productos registrados en esta categoría
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach

    <!-- Resumen -->
    <div class="summary">
        <h4>Resumen del Reporte</h4>
        <p><strong>Total de categorías:</strong> {{ $categorias->count() }}</p>
        <p><strong>Total de productos:</strong> {{ $categorias->sum(function($cat) { return $cat->products->count(); }) }}</p>
        <p><strong>Productos con stock bajo (≤5):</strong>
            {{ $categorias->sum(function($cat) {
                return $cat->products->where('Stock', '<=', 5)->count();
            }) }}
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>TAG & SOLE</strong> - Sistema de Gestión de Inventario</p>
        <p>Centro Comercial Galerías Toluca | +52 722 123 4567 | info@tagsole.com</p>
        <p>Reporte generado automáticamente el {{ now()->format('d/m/Y \a \l\a\s H:i:s') }}</p>
    </div>
</body>
</html>
