<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('orders.place') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Resumen del carrito -->
                            <div class="md:col-span-2">
                                <h3 class="text-lg font-medium mb-4">Productos en tu carrito</h3>

                                <div class="overflow-x-auto mb-6">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Producto
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Precio
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Cantidad
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                    Total
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($cartItems as $item)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10">
                                                                <img class="h-10 w-10 rounded-full" src="{{ asset('images/placeholder.png') }}" alt="{{ $item->product->Name }}">
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="text-sm font-medium text-gray-900">
                                                                    {{ $item->product->Name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">${{ number_format($item->Price, 2) }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">{{ $item->Quantity }}</div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">${{ number_format($item->Total, 2) }}</div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Dirección de envío -->
                                <h3 class="text-lg font-medium mb-4">Dirección de envío</h3>

                                @if($addresses->isEmpty())
                                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4">
                                        <p>No tienes direcciones registradas.</p>
                                        <a href="{{ route('addresses.create') }}" class="underline">Añadir dirección</a>
                                    </div>
                                @else
                                    <div class="mb-6">
                                        <select name="ShippingAddressId" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                            <option value="">Selecciona una dirección de envío</option>
                                            @foreach($addresses as $address)
                                                <option value="{{ $address->AddressId }}" {{ old('ShippingAddressId') == $address->AddressId ? 'selected' : '' }}>
                                                    {{ $address->AddressLine1 }}, {{ $address->City }}, {{ $address->State }}, {{ $address->Country }}
                                                    @if($address->IsDefault) (Predeterminada) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('ShippingAddressId')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                @endif

                                <!-- Dirección de facturación -->
                                <h3 class="text-lg font-medium mb-4">Dirección de facturación</h3>

                                <div class="mb-6">
                                    <div class="flex items-center mb-2">
                                        <input type="checkbox" id="same-address" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" checked>
                                        <label for="same-address" class="ml-2 text-sm text-gray-600">
                                            Usar la misma dirección para facturación
                                        </label>
                                    </div>

                                    <div id="billing-address-container" class="hidden">
                                        <select name="BillingAddressId" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block w-full">
                                            <option value="">Selecciona una dirección de facturación</option>
                                            @foreach($addresses as $address)
                                                <option value="{{ $address->AddressId }}" {{ old('BillingAddressId') == $address->AddressId ? 'selected' : '' }}>
                                                    {{ $address->AddressLine1 }}, {{ $address->City }}, {{ $address->State }}, {{ $address->Country }}
                                                    @if($address->IsDefault) (Predeterminada) @endif
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('BillingAddressId')
                                            <span class="text-red-600 text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Método de pago -->
                                <h3 class="text-lg font-medium mb-4">Método de pago</h3>

                                <div class="mb-6">
                                    <div class="space-y-2">
                                        <div class="flex items-center">
                                            <input type="radio" id="payment-credit-card" name="PaymentMethod" value="Tarjeta de Crédito" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('PaymentMethod') == 'Tarjeta de Crédito' ? 'checked' : '' }}>
                                            <label for="payment-credit-card" class="ml-2 text-sm text-gray-600">
                                                Tarjeta de Crédito/Débito
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="radio" id="payment-paypal" name="PaymentMethod" value="PayPal" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('PaymentMethod') == 'PayPal' ? 'checked' : '' }}>
                                            <label for="payment-paypal" class="ml-2 text-sm text-gray-600">
                                                PayPal
                                            </label>
                                        </div>

                                        <div class="flex items-center">
                                            <input type="radio" id="payment-transfer" name="PaymentMethod" value="Transferencia Bancaria" class="rounded-full border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" {{ old('PaymentMethod') == 'Transferencia Bancaria' ? 'checked' : '' }}>
                                            <label for="payment-transfer" class="ml-2 text-sm text-gray-600">
                                                Transferencia Bancaria
                                            </label>
                                        </div>
                                    </div>
                                    @error('PaymentMethod')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Resumen del pedido -->
                            <div class="md:col-span-1">
                                <div class="bg-gray-50 p-6 rounded-lg shadow">
                                    <h3 class="text-lg font-medium mb-4">Resumen del pedido</h3>

                                    <div class="space-y-3 mb-6">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Subtotal</span>
                                            <span>${{ number_format($subtotal, 2) }}</span>
                                        </div>

                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Envío</span>
                                            <span>${{ number_format($shippingCost, 2) }}</span>
                                        </div>

                                        <div class="border-t pt-3 mt-3">
                                            <div class="flex justify-between font-bold">
                                                <span>Total</span>
                                                <span>${{ number_format($total, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                                        Realizar Pedido
                                    </button>

                                    <p class="text-xs text-gray-500 mt-4">
                                        Al hacer clic en "Realizar Pedido", aceptas nuestros <a href="#" class="underline">términos y condiciones</a> y nuestra <a href="#" class="underline">política de privacidad</a>.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para manejar la opción de misma dirección para facturación
        document.addEventListener('DOMContentLoaded', function() {
            const sameAddressCheckbox = document.getElementById('same-address');
            const billingAddressContainer = document.getElementById('billing-address-container');
            const shippingAddressSelect = document.querySelector('select[name="ShippingAddressId"]');
            const billingAddressSelect = document.querySelector('select[name="BillingAddressId"]');

            // Función para sincronizar los selects
            function updateBillingAddress() {
                if (sameAddressCheckbox.checked) {
                    billingAddressContainer.classList.add('hidden');
                    // Seleccionar la misma dirección que el envío
                    billingAddressSelect.value = shippingAddressSelect.value;
                } else {
                    billingAddressContainer.classList.remove('hidden');
                }
            }

            // Inicializar
            updateBillingAddress();

            // Eventos de cambio
            sameAddressCheckbox.addEventListener('change', updateBillingAddress);
            shippingAddressSelect.addEventListener('change', function() {
                if (sameAddressCheckbox.checked) {
                    billingAddressSelect.value = this.value;
                }
            });
        });
    </script>
</x-app-layout>
