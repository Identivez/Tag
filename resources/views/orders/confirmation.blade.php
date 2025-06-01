<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirmación de Pedido') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="text-center mb-8">
                        <svg class="mx-auto h-12 w-12 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <h3 class="mt-2 text-2xl font-medium text-gray-900">¡Gracias por tu pedido!</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Pedido #{{ $order->OrderId }} • {{ \Carbon\Carbon::parse($order->OrderDate)->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Detalles del pedido -->
                    <div class="border rounded-lg overflow-hidden mb-6">
                        <div class="bg-gray-50 px-6 py-3 border-b">
                            <h4 class="font-medium">Detalles del pedido</h4>
                        </div>
                        <div class="px-6 py-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h5 class="font-medium text-gray-700 mb-2">Dirección de envío</h5>
                                    <address class="not-italic text-sm">
                                        {{ $order->shippingAddress->AddressLine1 }}<br>
                                        @if($order->shippingAddress->AddressLine2)
                                            {{ $order->shippingAddress->AddressLine2 }}<br>
                                        @endif
                                        {{ $order->shippingAddress->City }}, {{ $order->shippingAddress->State }} {{ $order->shippingAddress->ZipCode }}<br>
                                        {{ $order->shippingAddress->Country }}
                                    </address>
                                </div>

                                <div>
                                    <h5 class="font-medium text-gray-700 mb-2">Dirección de facturación</h5>
                                    <address class="not-italic text-sm">
                                        {{ $order->billingAddress->AddressLine1 }}<br>
                                        @if($order->billingAddress->AddressLine2)
                                            {{ $order->billingAddress->AddressLine2 }}<br>
                                        @endif
                                        {{ $order->billingAddress->City }}, {{ $order->billingAddress->State }} {{ $order->billingAddress->ZipCode }}<br>
                                        {{ $order->billingAddress->Country }}
                                    </address>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <h5 class="font-medium text-gray-700 mb-2">Método de envío</h5>
                                    <p class="text-sm">{{ $order->ShippingMethod }}</p>
                                </div>

                                <div>
                                    <h5 class="font-medium text-gray-700 mb-2">Método de pago</h5>
                                    <p class="text-sm">{{ $order->payment->PaymentMethod }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Productos del pedido -->
                    <div class="border rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-3 border-b">
                            <h4 class="font-medium">Productos</h4>
                        </div>
                        <div class="divide-y divide-gray-200">
                            @foreach($order->orderDetails as $detail)
                                <div class="px-6 py-4 flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 bg-gray-100 rounded-md overflow-hidden">
                                        <img src="{{ $detail->product->ImageUrl ?? asset('images/placeholder.png') }}"
                                            alt="{{ $detail->product->Name }}"
                                            class="h-full w-full object-center object-cover">
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <div class="flex justify-between">
                                            <h5 class="text-sm font-medium">{{ $detail->product->Name }}</h5>
                                            <p class="text-sm font-medium">${{ number_format($detail->UnitPrice * $detail->Quantity, 2) }}</p>
                                        </div>
                                        <div class="flex justify-between mt-1">
                                            <p class="text-sm text-gray-500">Cantidad: {{ $detail->Quantity }}</p>
                                            <p class="text-sm text-gray-500">${{ number_format($detail->UnitPrice, 2) }} c/u</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="bg-gray-50 px-6 py-4 border-t">
                            <div class="flex justify-between text-sm">
                                <span>Subtotal</span>
                                <span>${{ number_format($order->TotalAmount - $order->ShippingCost, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-sm mt-2">
                                <span>Envío</span>
                                <span>${{ number_format($order->ShippingCost, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-medium mt-4 pt-4 border-t border-gray-200">
                                <span>Total</span>
                                <span>${{ number_format($order->TotalAmount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Estado del pedido -->
                    <div class="mt-8 border rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-6 py-3 border-b">
                            <h4 class="font-medium">Estado actual del pedido</h4>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flex items-center">
                                <span class="px-3 py-1 text-sm leading-5 font-semibold rounded-full
                                    @if($order->OrderStatus == 'Completado') bg-green-100 text-green-800
                                    @elseif($order->OrderStatus == 'Cancelado') bg-red-100 text-red-800
                                    @elseif($order->OrderStatus == 'Enviado') bg-blue-100 text-blue-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $order->OrderStatus }}
                                </span>

                                @if($order->OrderStatus == 'Pendiente')
                                    <form action="{{ route('orders.cancel', $order->OrderId) }}" method="POST" class="ml-4">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de que quieres cancelar este pedido?')">
                                            Cancelar pedido
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="mt-8 flex flex-wrap justify-between">
                        <a href="{{ route('orders.user') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            Volver a mis pedidos
                        </a>

                        <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Continuar comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
