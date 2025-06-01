<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Favoritos') }}
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

                    @if($favorites->isEmpty())
                        <div class="text-center py-8">
                            <p class="text-gray-500 mb-4">No tienes productos favoritos aún.</p>
                            <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                                Explorar productos
                            </a>
                        </div>
                    @else
                        <div class="mb-4 flex justify-between items-center">
                            <h3 class="text-lg font-medium">Total: {{ $favorites->count() }} productos</h3>
                            <form action="{{ route('favorites.bulk-remove') }}" method="POST" id="bulk-remove-form">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-900 disabled:opacity-50" id="bulk-remove-button" disabled>
                                    Eliminar seleccionados
                                </button>
                            </form>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach($favorites as $favorite)
                                <div class="bg-white rounded-lg shadow overflow-hidden">
                                    <div class="relative">
                                        <input type="checkbox" form="bulk-remove-form" name="favorites[]" value="{{ $favorite->FavoriteId }}" class="absolute top-2 right-2 favorite-checkbox h-5 w-5 rounded border-gray-300">

                                        <a href="{{ route('products.show', $favorite->product->ProductId) }}">
                                            <img src="{{ $favorite->product->ImageUrl ?? asset('images/placeholder.png') }}"
                                                alt="{{ $favorite->product->Name }}"
                                                class="w-full h-48 object-cover">
                                        </a>
                                    </div>

                                    <div class="p-4">
                                        <h3 class="font-medium text-gray-900 truncate">
                                            <a href="{{ route('products.show', $favorite->product->ProductId) }}">
                                                {{ $favorite->product->Name }}
                                            </a>
                                        </h3>

                                        <p class="text-gray-900 mt-1">${{ number_format($favorite->product->Price, 2) }}</p>

                                        <div class="mt-3 flex justify-between">
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="ProductId" value="{{ $favorite->product->ProductId }}">
                                                <input type="hidden" name="Quantity" value="1">
                                                <button type="submit" class="text-indigo-600 hover:text-indigo-900">
                                                    Añadir al carrito
                                                </button>
                                            </form>

                                            <form action="{{ route('favorites.toggle') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="ProductId" value="{{ $favorite->product->ProductId }}">
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Eliminar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Script para habilitar/deshabilitar el botón de eliminar múltiples favoritos
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.favorite-checkbox');
            const bulkRemoveButton = document.getElementById('bulk-remove-button');

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateBulkRemoveButton);
            });

            function updateBulkRemoveButton() {
                const anyChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
                bulkRemoveButton.disabled = !anyChecked;
            }
        });
    </script>
</x-app-layout>
