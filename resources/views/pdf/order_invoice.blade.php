<!DOCTYPE html>
<html>
<head>
    <title>Factura de Pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #111;
        }
        .subtitle {
            font-size: 16px;
            margin-top: 5px;
            color: #666;
        }
        .date {
            margin-top: 10px;
            font-style: italic;
            color: #777;
        }
        .company-info {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .customer-info {
            margin-bottom: 25px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }
        .grid-container {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .grid-row {
            display: table-row;
        }
        .grid-cell {
            display: table-cell;
            padding: 5px 15px;
            vertical-align: top;
        }
        .invoice-details {
            margin-bottom: 30px;
            padding: 15px;
            background-color: #f0f7ff;
            border-radius: 5px;
            border-left: 4px solid #4a86e8;
        }
        .invoice-header {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #2a5db0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 25px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .quantity {
            text-align: center;
        }
        .price {
            text-align: right;
        }
        .summary {
            margin-top: 30px;
            margin-left: auto;
            width: 300px;
            border-top: 2px solid #ddd;
            padding-top: 15px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            font-weight: bold;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            font-size: 14px;
        }
        .footer {
            margin-top: 50px;
            font-size: 10px;
            text-align: center;
            color: #666;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .payment-info {
            margin: 30px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #28a745;
        }
        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 15px;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-completed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-shipped {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-canceled {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Sneakers Market</div>
        <div class="subtitle">Factura de Pedido</div>
        <div class="date">Fecha de emisión: {{ $date }}</div>
    </div>

    <div class="grid-container">
        <div class="grid-row">
            <div class="grid-cell">
                <div class="company-info">
                    <strong>Sneakers Market S.A. de C.V.</strong><br>
                    RFC: XAXX010101000<br>
                    Av. Tollocan #1023, Col. Santa Ana Tlapaltitlán<br>
                    Toluca, Estado de México, C.P. 50160<br>
                    Tel: (722) 123-4567<br>
                    contacto@sneakersmarket.com
                </div>
            </div>
            <div class="grid-cell">
                <div class="customer-info">
                    <strong>Cliente:</strong><br>
                    {{ $order->user->firstName }} {{ $order->user->lastName }}<br>
                    {{ $order->user->email }}<br>
                    {{ $order->user->phoneNumber ?? 'Sin teléfono registrado' }}<br>
                    <br>
                    <strong>Dirección de envío:</strong><br>
                    @if($order->shippingAddress)
                        {{ $order->shippingAddress->AddressLine1 }}<br>
                        @if($order->shippingAddress->AddressLine2)
                            {{ $order->shippingAddress->AddressLine2 }}<br>
                        @endif
                        {{ $order->shippingAddress->City }}, {{ $order->shippingAddress->State }}<br>
                        C.P. {{ $order->shippingAddress->ZipCode }}<br>
                        {{ $order->shippingAddress->Country }}
                    @else
                        No se proporcionó dirección de envío
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="invoice-details">
        <div class="invoice-header">Detalles del Pedido</div>
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; padding: 5px;"><strong>Número de Factura:</strong></td>
                <td style="border: none; padding: 5px;">INV-{{ $order->OrderId }}</td>
                <td style="border: none; padding: 5px;"><strong>Fecha del Pedido:</strong></td>
                <td style="border: none; padding: 5px;">{{ \Carbon\Carbon::parse($order->OrderDate)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 5px;"><strong>Método de Envío:</strong></td>
                <td style="border: none; padding: 5px;">{{ $order->ShippingMethod ?? 'Estándar' }}</td>
                <td style="border: none; padding: 5px;"><strong>Estado del Pedido:</strong></td>
                <td style="border: none; padding: 5px;">
                    <span class="status {{ strtolower($order->OrderStatus) === 'pendiente' ? 'status-pending' : (strtolower($order->OrderStatus) === 'completado' ? 'status-completed' : (strtolower($order->OrderStatus) === 'enviado' ? 'status-shipped' : (strtolower($order->OrderStatus) === 'cancelado' ? 'status-canceled' : ''))) }}">
                        {{ $order->OrderStatus }}
                    </span>
                </td>
            </tr>
            @if($order->payment)
            <tr>
                <td style="border: none; padding: 5px;"><strong>Método de Pago:</strong></td>
                <td style="border: none; padding: 5px;">{{ $order->payment->PaymentMethod }}</td>
                <td style="border: none; padding: 5px;"><strong>Estado del Pago:</strong></td>
                <td style="border: none; padding: 5px;">{{ $order->payment->PaymentStatus }}</td>
            </tr>
            @endif
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">#</th>
                <th style="width: 40%;">Producto</th>
                <th style="width: 15%;" class="quantity">Cantidad</th>
                <th style="width: 15%;" class="price">Precio Unitario</th>
                <th style="width: 20%;" class="price">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($details as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product->Name }}</strong>
                        @if($item->product->Brand)
                            <br><small>Marca: {{ $item->product->Brand }}</small>
                        @endif
                    </td>
                    <td class="quantity">{{ $item->Quantity }}</td>
                    <td class="price">${{ number_format($item->UnitPrice, 2) }}</td>
                    <td class="price">${{ number_format($item->Quantity * $item->UnitPrice, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <span>Subtotal:</span>
            <span>${{ number_format($order->TotalAmount - ($order->ShippingCost ?? 0), 2) }}</span>
        </div>
        <div class="summary-row">
            <span>Envío:</span>
            <span>${{ number_format($order->ShippingCost ?? 0, 2) }}</span>
        </div>
        @if(isset($order->DiscountAmount) && $order->DiscountAmount > 0)
        <div class="summary-row">
            <span>Descuento:</span>
            <span>-${{ number_format($order->DiscountAmount, 2) }}</span>
        </div>
        @endif
        <div class="summary-row summary-total">
            <span>Total:</span>
            <span>${{ number_format($order->TotalAmount, 2) }}</span>
        </div>
    </div>

    @if($order->payment)
    <div class="payment-info">
        <strong>Información de Pago:</strong><br>
        Método: {{ $order->payment->PaymentMethod }}<br>
        Fecha: {{ \Carbon\Carbon::parse($order->payment->TransactionDate)->format('d/m/Y H:i') }}<br>
        Estado: {{ $order->payment->PaymentStatus }}<br>
        @if($order->payment->PaymentProvider)
            Proveedor: {{ $order->payment->PaymentProvider }}
        @endif
    </div>
    @endif

    <div class="footer">
        <p>Gracias por su compra en Sneakers Market</p>
        <p>Para cualquier consulta relacionada con su pedido, por favor contáctenos en: soporte@sneakersmarket.com</p>
        <p>Este documento es una representación digital de su factura y es válido sin firma ni sello.</p>
        <p>&copy; {{ date('Y') }} Sneakers Market - Todos los derechos reservados</p>
    </div>
</body>
</html>
