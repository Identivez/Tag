@extends('template.master')

@section('contenido_central')

<!-- Start Content -->
<div class="container py-5">
    <div class="row">

        <!-- Sidebar con filtros -->
        <div class="col-lg-3">
            <h1 class="h2 pb-4">Filtros</h1>

            <!-- Formulario de filtros -->
            <form method="GET" action="{{ route('shop.index') }}" id="filter-form">

                <!-- Categorías -->
                <div class="mb-4">
                    <h6>Categorías</h6>
                    <ul class="list-unstyled">
                        <li class="pb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="CategoryId" value="" id="cat_all"
                                       {{ !request('CategoryId') ? 'checked' : '' }} onchange="this.form.submit()">
                                <label class="form-check-label" for="cat_all">
                                    Todas las categorías
                                </label>
                            </div>
                        </li>
                        @foreach($categories as $category)
                        <li class="pb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="CategoryId" value="{{ $category->CategoryId }}"
                                       id="cat_{{ $category->CategoryId }}"
                                       {{ request('CategoryId') == $category->CategoryId ? 'checked' : '' }}
                                       onchange="this.form.submit()">
                                <label class="form-check-label" for="cat_{{ $category->CategoryId }}">
                                    {{ $category->Name }}
                                </label>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Rango de precios -->
                <div class="mb-4">
                    <h6>Rango de Precio</h6>
                    <div class="row">
                        <div class="col-6">
                            <input type="number" class="form-control form-control-sm" name="min_price"
                                   placeholder="Mín" value="{{ request('min_price') }}" min="0" step="0.01">
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control form-control-sm" name="max_price"
                                   placeholder="Máx" value="{{ request('max_price') }}" min="0" step="0.01">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success mt-2">Aplicar</button>
                </div>

                <!-- Búsqueda -->
                <div class="mb-4">
                    <h6>Buscar</h6>
                    <div class="input-group">
                        <input type="text" class="form-control" name="search" placeholder="Buscar productos..."
                               value="{{ request('search') }}">
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <!-- Mantener otros parámetros -->
                <input type="hidden" name="sort" value="{{ request('sort', 'newest') }}">
            </form>

            <!-- Limpiar filtros -->
            @if(request()->hasAny(['CategoryId', 'min_price', 'max_price', 'search']))
            <div class="mb-4">
                <a href="{{ route('shop.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-times"></i> Limpiar Filtros
                </a>
            </div>
            @endif
        </div>

        <!-- Productos -->
        <div class="col-lg-9">
            <!-- Barra de ordenamiento -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted">
                        Mostrando {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}
                        de {{ $products->total() }} productos
                        @if(request('search'))
                            para "{{ request('search') }}"
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <form method="GET" action="{{ route('shop.index') }}" class="d-flex align-items-center">
                            <!-- Mantener filtros actuales -->
                            @if(request('CategoryId'))
                                <input type="hidden" name="CategoryId" value="{{ request('CategoryId') }}">
                            @endif
                            @if(request('search'))
                                <input type="hidden" name="search" value="{{ request('search') }}">
                            @endif
                            @if(request('min_price'))
                                <input type="hidden" name="min_price" value="{{ request('min_price') }}">
                            @endif
                            @if(request('max_price'))
                                <input type="hidden" name="max_price" value="{{ request('max_price') }}">
                            @endif

                            <label for="sort" class="me-2 text-muted">Ordenar por:</label>
                            <select name="sort" id="sort" class="form-select form-select-sm" onchange="this.form.submit()" style="width: auto;">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más recientes</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Precio: menor a mayor</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Precio: mayor a menor</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nombre A-Z</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Grid de productos -->
            @if($products->count() > 0)
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card product-wap rounded-0 h-100">
                            <div class="card rounded-0 position-relative">
                                @if($product->images && $product->images->first())
                                    <img class="card-img rounded-0 img-fluid"
                                         src="{{ asset('storage/' . $product->images->first()->ImageFileName) }}"
                                         alt="{{ $product->Name }}" style="height: 250px; object-fit: cover;">
                                @else
                                    <div class="card-img rounded-0 bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif

                                <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                    <ul class="list-unstyled">
                                        @auth
                                            <li>
                                                <button class="btn btn-success text-white favorite-btn"
                                                        data-product-id="{{ $product->ProductId }}"
                                                        title="Agregar a favoritos">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                            </li>
                                        @endauth
                                        <li>
  <a href="{{ route('shop.product', $product->ProductId) }}">
    Ver producto
</a>


                                        </li>
                                        @auth
                                            <li>
                                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="ProductId" value="{{ $product->ProductId }}">
                                                    <input type="hidden" name="Quantity" value="1">
                                                    <button type="submit" class="btn btn-success text-white mt-2" title="Agregar al carrito">
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                            </li>
                                        @endauth
                                    </ul>
                                </div>

                                @if($product->Stock <= 5 && $product->Stock > 0)
                                    <span class="badge bg-warning position-absolute top-0 start-0 m-2">¡Últimas unidades!</span>
                                @elseif($product->Stock == 0)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">Agotado</span>
                                @endif
                            </div>

                            <div class="card-body d-flex flex-column">
                                <a href="{{ route('shop.product', $product->ProductId) }}"
                                   class="h3 text-decoration-none text-dark">{{ $product->Name }}</a>

                                @if($product->Brand)
                                    <p class="text-muted mb-1">{{ $product->Brand }}</p>
                                @endif

                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-2">
                                    <li>
                                        @if($product->category)
                                            <small class="text-muted">{{ $product->category->Name }}</small>
                                        @endif
                                    </li>
                                    <li>
                                        @php
                                            $rating = $product->reviews ? $product->reviews->avg('Rating') : 0;
                                        @endphp
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $rating)
                                                <i class="text-warning fa fa-star fa-sm"></i>
                                            @else
                                                <i class="text-muted fa fa-star fa-sm"></i>
                                            @endif
                                        @endfor
                                    </li>
                                </ul>

                                <p class="card-text flex-grow-1">
                                    {{ Str::limit($product->Description, 80) }}
                                </p>

                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="h5 text-success">${{ number_format($product->Price, 2) }}</span>
                                        </div>
                                        <div>
                                            @if($product->Stock > 0)
                                                <small class="text-success">En stock: {{ $product->Stock }}</small>
                                            @else
                                                <small class="text-danger">Sin stock</small>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Paginación -->
                <div class="d-flex justify-content-center">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Sin productos -->
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4>No se encontraron productos</h4>
                    <p class="text-muted">
                        @if(request()->hasAny(['CategoryId', 'search', 'min_price', 'max_price']))
                            Intenta ajustar tus filtros de búsqueda.
                        @else
                            Aún no hay productos disponibles.
                        @endif
                    </p>
                    @if(request()->hasAny(['CategoryId', 'search', 'min_price', 'max_price']))
                        <a href="{{ route('shop.index') }}" class="btn btn-success">Ver Todos los Productos</a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>
<!-- End Content -->

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Manejo de favoritos
    document.querySelectorAll('.favorite-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');

            fetch('{{ route("favorites.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    ProductId: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'added') {
                    this.innerHTML = '<i class="fas fa-heart"></i>';
                    this.classList.add('btn-danger');
                    this.classList.remove('btn-success');
                } else {
                    this.innerHTML = '<i class="far fa-heart"></i>';
                    this.classList.add('btn-success');
                    this.classList.remove('btn-danger');
                }

                // Mostrar mensaje
                showToast(data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error al actualizar favoritos', 'error');
            });
        });
    });

    // Función para mostrar toast
    function showToast(message, type = 'success') {
        // Crear elemento toast
        const toast = document.createElement('div');
        toast.className = `toast show position-fixed bottom-0 end-0 m-3`;
        toast.style.zIndex = '1100';
        toast.innerHTML = `
            <div class="toast-header bg-${type === 'error' ? 'danger' : 'success'} text-white">
                <strong class="me-auto">${type === 'error' ? 'Error' : 'Éxito'}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;

        document.body.appendChild(toast);

        // Auto-remover después de 3 segundos
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 3000);
    }
});
</script>
@endsection
