<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de tu pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 150px;
            margin-bottom: 20px;
        }
        .order-info {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .products {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f8f9fa;
        }
        .summary {
            background-color: #f8f9fa;
            padding: 15px;
            margin-top: 20px;
            text-align: right;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>¡Gracias por tu compra!</h1>
            <p>Hemos recibido tu pedido y está siendo procesado.</p>
        </div>

        <div class="order-info">
            <h2>Información del pedido</h2>
            <p><strong>Número de pedido:</strong> #{{ $order->OrderId }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($order->OrderDate)->format('d/m/Y H:i') }}</p>
            <p><strong>Estado:</strong> {{ $order->OrderStatus }}</p>
        </div>

        <div class="products">
            <h2>Productos</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderDetails as $item)
                        <tr>
                            <td>{{ $item->product->Name }}</td>
                            <td>{{ $item->Quantity }}</td>
                            <td>${{ number_format($item->UnitPrice, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="summary">
            <p><strong>Subtotal:</strong> ${{ number_format($order->TotalAmount - $order->ShippingCost, 2) }}</p>
            <p><strong>Costo de envío:</strong> ${{ number_format($order->ShippingCost, 2) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->TotalAmount, 2) }}</p>
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('user.orders') }}" class="btn">Ver mis pedidos</a>
        </div>

        <div class="footer">
            <p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
            <p>&copy; {{ date('Y') }} Sneakers Market. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
