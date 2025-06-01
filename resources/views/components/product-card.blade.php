@props(['product'])

<div class="bg-white rounded-lg shadow overflow-hidden h-full">
    <div class="relative">
        <a href="{{ route('products.show', $product->ProductId) }}">
            <img src="{{ $product->ImageUrl ?? asset('images/placeholder.png') }}"
                alt="{{ $product->Name }}"
                class="w-full h-48 object-cover">
        </a>

        @auth
            <button type="button"
                data-product-id="{{ $product->ProductId }}"
                class="absolute top-2 right-2 favorite-button text-gray-300 hover:text-red-500 focus:outline-none">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
            </button>
        @endauth
    </div>

    <div class="p-4">
        <h3 class="font-medium text-gray-900 truncate">
            <a href="{{ route('products.show', $product->ProductId) }}">
                {{ $product->Name }}
            </a>
        </h3>

        <p class="text-gray-500 text-sm truncate">{{ $product->Brand }}</p>

        <div class="mt-2 flex justify-between items-center">
            <span class="text-gray-900 font-medium">${{ number_format($product->Price, 2) }}</span>

            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="ProductId" value="{{ $product->ProductId }}">
                <input type="hidden" name="Quantity" value="1">
                <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Añadir
                </button>
            </form>
        </div>
    </div>
</div>
