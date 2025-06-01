<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
        }
        .subtitle {
            font-size: 14px;
            margin-top: 5px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 20px;
            font-size: 10px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Sneakers Market</div>
        <div class="subtitle">Reporte de Productos</div>
        <div>Fecha: {{ $date }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Marca</th>
                <th>Precio</th>
                <th>Inventario</th>
                <th>Categoría</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $product)
                <tr>
                    <td>{{ $product->ProductId }}</td>
                    <td>{{ $product->Name }}</td>
                    <td>{{ $product->Brand }}</td>
                    <td>${{ number_format($product->Price, 2) }}</td>
                    <td>{{ $product->Stock }}</td>
                    <td>{{ $product->category->Name ?? 'Sin categoría' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Sneakers Market - Todos los derechos reservados © {{ date('Y') }}</p>
        <p>Este documento fue generado automáticamente y es válido sin firma.</p>
    </div>
</body>
</html>
