<!DOCTYPE html>
<html>
<head>
    <title>Stock Bajo - TAG & SOLE</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #dc3545;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #dc3545;
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

        .alert-banner {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #dc3545;
            text-align: center;
            font-weight: bold;
        }

        .report-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border-left: 4px solid #dc3545;
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
            background-color: #dc3545;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #dc3545;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            background-color: white;
        }

        tr:nth-child(even) td {
            background-color: #fff5f5;
        }

        .price {
            text-align: right;
            font-weight: bold;
            color: #28a745;
        }

        .stock {
            text-align: center;
            font-weight: bold;
            color: #dc3545;
            background-color: #f8d7da;
        }

        .stock.critical {
            background-color: #dc3545;
            color: white;
        }

        .category {
            text-align: center;
            font-style: italic;
        }

        .priority {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }

        .priority.urgent {
            color: #dc3545;
        }

        .priority.high {
            color: #fd7e14;
        }

        .priority.medium {
            color: #ffc107;
        }

        .summary {
            background-color: #f8d7da;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
            border: 1px solid #dc3545;
        }

        .summary h4 {
            color: #dc3545;
            margin-top: 0;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            border-left: 3px solid #dc3545;
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
            color: #28a745;
            background-color: #d4edda;
            padding: 20px;
        }

        .action-needed {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .action-needed h4 {
            color: #856404;
            margin-top: 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TAG & SOLE</h1>
        <div class="store-name">Sneakers & Moda Urbana</div>
        <div class="subtitle">Reporte de Productos con Stock Bajo</div>
    </div>

    <!-- Alerta Principal -->
    <div class="alert-banner">
        ALERTA: PRODUCTOS CON INVENTARIO CRÍTICO - ACCIÓN REQUERIDA
    </div>

    <!-- Información del Reporte -->
    <div class="report-info">
        <p><strong>Fecha de generación:</strong> {{ $date->format('d/m/Y H:i:s') }}</p>
        <p><strong>Tipo de reporte:</strong> Productos con stock bajo (≤10 unidades)</p>
        <p><strong>Sistema:</strong> TAG & SOLE - Panel de Administración</p>
        <p><strong>Productos en alerta:</strong> {{ count($productos) }}</p>
        <p><strong>Umbral de alerta:</strong> 10 unidades o menos</p>
    </div>

    <!-- Acción Requerida -->
    @if(count($productos) > 0)
    <div class="action-needed">
        <h4>Acciones Recomendadas:</h4>
        <ul>
            <li><strong>Contactar proveedores</strong> de productos críticos (stock ≤3)</li>
            <li><strong>Programar pedidos urgentes</strong> para evitar desabastos</li>
            <li><strong>Revisar demanda</strong> de productos con stock bajo recurrente</li>
            <li><strong>Actualizar niveles mínimos</strong> de inventario según rotación</li>
        </ul>
    </div>
    @endif

    <!-- Tabla de Productos -->
    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Producto</th>
                <th style="width: 15%;">Stock Actual</th>
                <th style="width: 15%;">Precio</th>
                <th style="width: 20%;">Categoría</th>
                <th style="width: 10%;">Prioridad</th>
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
                <td class="stock {{ $prod->Stock <= 3 ? 'critical' : '' }}">
                    {{ $prod->Stock }}
                    @if($prod->Stock <= 3)
                        <br><small>(CRÍTICO)</small>
                    @elseif($prod->Stock <= 5)
                        <br><small>(MUY BAJO)</small>
                    @else
                        <br><small>(BAJO)</small>
                    @endif
                </td>
                <td class="price">${{ number_format($prod->Price, 2) }}</td>
                <td class="category">{{ $prod->category->Name ?? 'Sin categoría' }}</td>
                <td class="priority {{ $prod->Stock <= 3 ? 'urgent' : ($prod->Stock <= 5 ? 'high' : 'medium') }}">
                    @if($prod->Stock <= 3)
                        URGENTE
                    @elseif($prod->Stock <= 5)
                        ALTA
                    @else
                        MEDIA
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">
                    ¡EXCELENTE! No hay productos con stock bajo en este momento
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Resumen -->
    <div class="summary">
        <h4>Análisis de Stock Crítico</h4>
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Stock Crítico (≤3)</strong><br>
                {{ collect($productos)->where('Stock', '<=', 3)->count() }} productos
            </div>
            <div class="summary-item">
                <strong>Stock Muy Bajo (4-5)</strong><br>
                {{ collect($productos)->where('Stock', '>', 3)->where('Stock', '<=', 5)->count() }} productos
            </div>
            <div class="summary-item">
                <strong>Stock Bajo (6-10)</strong><br>
                {{ collect($productos)->where('Stock', '>', 5)->where('Stock', '<=', 10)->count() }} productos
            </div>
        </div>

        @if(count($productos) > 0)
        <div style="margin-top: 15px; text-align: center; padding: 10px; background-color: white; border-radius: 5px;">
            <strong>Valor Total en Riesgo:</strong>
            ${{ number_format(collect($productos)->sum(function($p) { return $p->Price * $p->Stock; }), 2) }}
        </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>TAG & SOLE</strong> - Sistema de Gestión de Inventario</p>
        <p>Centro Comercial Galerías Toluca | +52 722 123 4567 | info@tagsole.com</p>
        <p>Reporte generado automáticamente el {{ now()->format('d/m/Y \a \l\a\s H:i:s') }}</p>
        <p style="color: #dc3545; font-weight: bold;">REVISIÓN REQUERIDA - INVENTARIO CRÍTICO</p>
    </div>
</body>
</html>
