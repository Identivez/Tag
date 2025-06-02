<!DOCTYPE html>
<html>
<head>
    <title>Usuarios y Pedidos - TAG & SOLE</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #007bff;
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
            border-left: 4px solid #007bff;
        }

        .report-info p {
            margin: 5px 0;
            font-size: 14px;
        }

        .stats-banner {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 25px;
            border: 1px solid #007bff;
            text-align: center;
        }

        .stats-banner h4 {
            color: #007bff;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th {
            background-color: #007bff;
            color: white;
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #007bff;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 10px 8px;
            background-color: white;
        }

        tr:nth-child(even) td {
            background-color: #f8f9fa;
        }

        .user-name {
            font-weight: bold;
            color: #007bff;
        }

        .email {
            color: #666;
            font-style: italic;
        }

        .orders-count {
            text-align: center;
            font-weight: bold;
        }

        .orders-count.high {
            color: #28a745;
            background-color: #d4edda;
        }

        .orders-count.medium {
            color: #ffc107;
            background-color: #fff3cd;
        }

        .orders-count.low {
            color: #6c757d;
            background-color: #f8f9fa;
        }

        .orders-count.none {
            color: #dc3545;
            background-color: #f8d7da;
        }

        .registration-date {
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .customer-tier {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            padding: 3px 6px;
            border-radius: 3px;
        }

        .customer-tier.vip {
            background-color: #ffd700;
            color: #333;
        }

        .customer-tier.frequent {
            background-color: #28a745;
            color: white;
        }

        .customer-tier.regular {
            background-color: #007bff;
            color: white;
        }

        .customer-tier.new {
            background-color: #6c757d;
            color: white;
        }

        .summary {
            background-color: #e3f2fd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 30px;
            border: 1px solid #007bff;
        }

        .summary h4 {
            color: #007bff;
            margin-top: 0;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 15px;
            margin-top: 15px;
        }

        .summary-item {
            background-color: white;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            border-left: 3px solid #007bff;
        }

        .insights {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #ffc107;
        }

        .insights h4 {
            color: #856404;
            margin-top: 0;
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
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>TAG & SOLE</h1>
        <div class="store-name">Sneakers & Moda Urbana</div>
        <div class="subtitle">Reporte de Usuarios y Actividad de Pedidos</div>
    </div>

    <!-- Información del Reporte -->
    <div class="report-info">
        <p><strong>Fecha de generación:</strong> {{ $date->format('d/m/Y H:i:s') }}</p>
        <p><strong>Tipo de reporte:</strong> Análisis de usuarios y comportamiento de compra</p>
        <p><strong>Sistema:</strong> TAG & SOLE - Panel de Administración</p>
        <p><strong>Total de usuarios:</strong> {{ count($usuarios) }}</p>
        <p><strong>Usuarios con pedidos:</strong> {{ collect($usuarios)->where('orders_count', '>', 0)->count() }}</p>
    </div>

    <!-- Banner de Estadísticas -->
    <div class="stats-banner">
        <h4>Análisis de Actividad de Clientes</h4>
        <p>Clasificación por volumen de pedidos y nivel de engagement con la plataforma</p>
    </div>

    <!-- Tabla de Usuarios -->
    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Cliente</th>
                <th style="width: 30%;">Email</th>
                <th style="width: 15%;">Total Pedidos</th>
                <th style="width: 15%;">Fecha Registro</th>
                <th style="width: 15%;">Categoría</th>
            </tr>
        </thead>
        <tbody>
            @forelse($usuarios as $user)
            <tr>
                <td class="user-name">
                    {{ $user->firstName }} {{ $user->lastName }}
                    @if($user->orders_count >= 10)
                        <br><small style="color: #ffd700;">★ Cliente VIP</small>
                    @elseif($user->orders_count >= 5)
                        <br><small style="color: #28a745;">⭐ Cliente Frecuente</small>
                    @endif
                </td>
                <td class="email">{{ $user->email }}</td>
                <td class="orders-count {{ $user->orders_count >= 10 ? 'high' : ($user->orders_count >= 3 ? 'medium' : ($user->orders_count > 0 ? 'low' : 'none')) }}">
                    {{ $user->orders_count }}
                    @if($user->orders_count == 0)
                        <br><small>(SIN PEDIDOS)</small>
                    @elseif($user->orders_count >= 10)
                        <br><small>(ALTO)</small>
                    @elseif($user->orders_count >= 3)
                        <br><small>(MEDIO)</small>
                    @else
                        <br><small>(BAJO)</small>
                    @endif
                </td>
                <td class="registration-date">
                    @if($user->createdAt)
                        {{ \Carbon\Carbon::parse($user->createdAt)->format('d/m/Y') }}
                        <br><small>{{ \Carbon\Carbon::parse($user->createdAt)->diffForHumans() }}</small>
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <div class="customer-tier {{ $user->orders_count >= 10 ? 'vip' : ($user->orders_count >= 5 ? 'frequent' : ($user->orders_count > 0 ? 'regular' : 'new')) }}">
                        @if($user->orders_count >= 10)
                            VIP
                        @elseif($user->orders_count >= 5)
                            FRECUENTE
                        @elseif($user->orders_count > 0)
                            REGULAR
                        @else
                            NUEVO
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="no-data">
                    No hay usuarios registrados en el sistema
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Resumen -->
    <div class="summary">
        <h4>Segmentación de Clientes</h4>
        <div class="summary-grid">
            <div class="summary-item">
                <strong>Clientes VIP</strong><br>
                {{ collect($usuarios)->where('orders_count', '>=', 10)->count() }} usuarios<br>
                <small>(≥10 pedidos)</small>
            </div>
            <div class="summary-item">
                <strong>Clientes Frecuentes</strong><br>
                {{ collect($usuarios)->where('orders_count', '>=', 5)->where('orders_count', '<', 10)->count() }} usuarios<br>
                <small>(5-9 pedidos)</small>
            </div>
            <div class="summary-item">
                <strong>Clientes Regulares</strong><br>
                {{ collect($usuarios)->where('orders_count', '>', 0)->where('orders_count', '<', 5)->count() }} usuarios<br>
                <small>(1-4 pedidos)</small>
            </div>
            <div class="summary-item">
                <strong>Usuarios Nuevos</strong><br>
                {{ collect($usuarios)->where('orders_count', '=', 0)->count() }} usuarios<br>
                <small>(sin pedidos)</small>
            </div>
        </div>
    </div>

    <!-- Insights -->
    <div class="insights">
        <h4>Insights y Recomendaciones</h4>
        <ul>
            <li><strong>Tasa de conversión:</strong> {{ count($usuarios) > 0 ? round((collect($usuarios)->where('orders_count', '>', 0)->count() / count($usuarios)) * 100, 1) : 0 }}% de usuarios han realizado al menos un pedido</li>
            <li><strong>Clientes de alto valor:</strong> {{ collect($usuarios)->where('orders_count', '>=', 5)->count() }} usuarios representan el segmento más valioso</li>
            <li><strong>Oportunidad:</strong> {{ collect($usuarios)->where('orders_count', '=', 0)->count() }} usuarios sin pedidos pueden ser objetivo de campañas de activación</li>
            <li><strong>Retención:</strong> Enfocar estrategias de fidelización en clientes con 1-4 pedidos para aumentar frecuencia</li>
        </ul>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p><strong>TAG & SOLE</strong> - Sistema de Gestión de Clientes</p>
        <p>Centro Comercial Galerías Toluca | +52 722 123 4567 | info@tagsole.com</p>
        <p>Reporte generado automáticamente el {{ now()->format('d/m/Y \a \l\a\s H:i:s') }}</p>
        <p style="color: #007bff; font-weight: bold;">ANÁLISIS DE COMPORTAMIENTO DE CLIENTES</p>
    </div>
</body>
</html>
