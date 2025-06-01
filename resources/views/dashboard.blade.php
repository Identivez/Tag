@extends('template.master')

@section('contenido_central')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <h2 class="h3 mb-3">¡Bienvenido, {{ Auth::user()->firstName }}!</h2>
                <p class="text-muted">Gestiona tu cuenta, revisa tus pedidos y mantente al día con las últimas tendencias en TAG & SOLE.</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3">
            <div class="bg-white shadow-sm rounded p-3 mb-4">
                <h5 class="border-bottom pb-2 mb-3">Mi Cuenta</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none {{ request()->routeIs('dashboard') ? 'text-success fw-bold' : 'text-dark' }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('profile.edit') }}" class="text-decoration-none text-dark">
                            <i class="fas fa-user me-2"></i>Mi Perfil
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('orders.user') }}" class="text-decoration-none text-dark">
                            <i class="fas fa-shopping-bag me-2"></i>Mis Pedidos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('favorites.user') }}" class="text-decoration-none text-dark">
                            <i class="fas fa-heart me-2"></i>Favoritos
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('cart.view') }}" class="text-decoration-none text-dark">
                            <i class="fas fa-shopping-cart me-2"></i>Mi Carrito
                        </a>
                    </li>
                </ul>
            </div>

            @if(Auth::user()->isAdmin())
            <div class="bg-white shadow-sm rounded p-3">
                <h5 class="border-bottom pb-2 mb-3 text-danger">Panel de Administración</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-danger">
                            <i class="fas fa-cogs me-2"></i>Admin Dashboard
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.productos.index') }}" class="text-decoration-none text-danger">
                            <i class="fas fa-box me-2"></i>Gestionar Productos
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9">
            <!-- Estadísticas del usuario -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="bg-white shadow-sm rounded p-3 text-center">
                        <div class="text-success">
                            <i class="fas fa-shopping-bag fa-2x"></i>
                        </div>
                        @php
                            $userOrdersCount = 0;
                            try {
                                $userOrdersCount = \App\Models\Order::where('UserId', Auth::id())->count();
                            } catch (\Exception $e) {
                                // Si hay error, mantener en 0
                            }
                        @endphp
                        <h4 class="mt-2">{{ $userOrdersCount }}</h4>
                        <p class="text-muted mb-0">Pedidos Realizados</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white shadow-sm rounded p-3 text-center">
                        <div class="text-danger">
                            <i class="fas fa-heart fa-2x"></i>
                        </div>
                        @php
                            $userFavoritesCount = 0;
                            try {
                                $userFavoritesCount = \App\Models\Favorite::where('UserId', Auth::id())->count();
                            } catch (\Exception $e) {
                                // Si hay error, mantener en 0
                            }
                        @endphp
                        <h4 class="mt-2">{{ $userFavoritesCount }}</h4>
                        <p class="text-muted mb-0">Productos Favoritos</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="bg-white shadow-sm rounded p-3 text-center">
                        <div class="text-warning">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                        @php
                            $userCartItemsCount = 0;
                            try {
                                $userCartItemsCount = \App\Models\CartItem::where('UserId', Auth::id())->sum('Quantity') ?? 0;
                            } catch (\Exception $e) {
                                // Si hay error, mantener en 0
                            }
                        @endphp
                        <h4 class="mt-2">{{ $userCartItemsCount }}</h4>
                        <p class="text-muted mb-0">Items en Carrito</p>
                    </div>
                </div>
            </div>

            <!-- Pedidos recientes -->
            <div class="bg-white shadow-sm rounded p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Pedidos Recientes</h5>
                    <a href="{{ route('orders.user') }}" class="btn btn-sm btn-outline-success">Ver Todos</a>
                </div>

                @php
                    $recentOrders = collect();
                    try {
                        $recentOrders = \App\Models\Order::where('UserId', Auth::id())
                            ->orderBy('OrderDate', 'desc')
                            ->take(3)
                            ->get();
                    } catch (\Exception $e) {
                        // Si hay error, mantener colección vacía
                    }
                @endphp

                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pedido #</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->OrderId }}</td>
                                    <td>{{ $order->OrderDate ? \Carbon\Carbon::parse($order->OrderDate)->format('d/m/Y') : 'N/A' }}</td>
                                    <td>${{ number_format($order->TotalAmount ?? 0, 2) }}</td>
                                    <td>
                                        <span class="badge
                                            @if($order->OrderStatus == 'Completado') bg-success
                                            @elseif($order->OrderStatus == 'Cancelado') bg-danger
                                            @elseif($order->OrderStatus == 'Enviado') bg-info
                                            @else bg-warning @endif">
                                            {{ $order->OrderStatus ?? 'Pendiente' }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.confirmation', $order->OrderId) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aún no has realizado ningún pedido.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-success">Explorar Productos</a>
                    </div>
                @endif
            </div>

            <!-- Productos favoritos recientes -->
            <div class="bg-white shadow-sm rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Productos Favoritos</h5>
                    <a href="{{ route('favorites.user') }}" class="btn btn-sm btn-outline-danger">Ver Todos</a>
                </div>

                @php
                    $recentFavorites = collect();
                    try {
                        $recentFavorites = \App\Models\Favorite::where('UserId', Auth::id())
                            ->with('product.images')
                            ->orderBy('AddedAt', 'desc')
                            ->take(4)
                            ->get();
                    } catch (\Exception $e) {
                        // Si hay error, mantener colección vacía
                    }
                @endphp

                @if($recentFavorites->count() > 0)
                    <div class="row">
                        @foreach($recentFavorites as $favorite)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                @if($favorite->product && $favorite->product->images && $favorite->product->images->first())
                                    <img src="{{ asset('storage/' . $favorite->product->images->first()->ImageFileName) }}"
                                         class="card-img-top" alt="{{ $favorite->product->Name }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">{{ $favorite->product ? Str::limit($favorite->product->Name, 20) : 'Producto no disponible' }}</h6>
                                    @if($favorite->product)
                                        <p class="card-text text-success mb-1">${{ number_format($favorite->product->Price ?? 0, 2) }}</p>
                                        <a href="{{ route('shop.show', $favorite->product->ProductId) }}" class="btn btn-sm btn-outline-success">Ver</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No tienes productos favoritos aún.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-danger">Explorar Productos</a>
                    </div>
                @endif
            </div>d p-3 text-center">
                        <div class="text-warning">
                            <i class="fas fa-shopping-cart fa-2x"></i>
                        </div>
                        <h4 class="mt-2">{{ Auth::user()->cartItems ? Auth::user()->cartItems->sum('Quantity') : 0 }}</h4>
                        <p class="text-muted mb-0">Items en Carrito</p>
                    </div>
                </div>
            </div>

            <!-- Pedidos recientes -->
            <div class="bg-white shadow-sm rounded p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Pedidos Recientes</h5>
                    <a href="{{ route('orders.user') }}" class="btn btn-sm btn-outline-success">Ver Todos</a>
                </div>

                @php
                    $recentOrders = Auth::user()->orders ? Auth::user()->orders->take(3) : collect();
                @endphp

                @if($recentOrders->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Pedido #</th>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                <tr>
                                    <td>#{{ $order->OrderId }}</td>
                                    <td>{{ $order->OrderDate ? $order->OrderDate->format('d/m/Y') : 'N/A' }}</td>
                                    <td>${{ number_format($order->TotalAmount, 2) }}</td>
                                    <td>
                                        <span class="badge
                                            @if($order->OrderStatus == 'Completado') bg-success
                                            @elseif($order->OrderStatus == 'Cancelado') bg-danger
                                            @elseif($order->OrderStatus == 'Enviado') bg-info
                                            @else bg-warning @endif">
                                            {{ $order->OrderStatus }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('orders.confirmation', $order->OrderId) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Aún no has realizado ningún pedido.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-success">Explorar Productos</a>
                    </div>
                @endif
            </div>

            <!-- Productos favoritos recientes -->
            <div class="bg-white shadow-sm rounded p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">Productos Favoritos</h5>
                    <a href="{{ route('favorites.user') }}" class="btn btn-sm btn-outline-danger">Ver Todos</a>
                </div>

                @php
                    $recentFavorites = Auth::user()->favorites ? Auth::user()->favorites->take(4) : collect();
                @endphp

                @if($recentFavorites->count() > 0)
                    <div class="row">
                        @foreach($recentFavorites as $favorite)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100">
                                @if($favorite->product && $favorite->product->images && $favorite->product->images->first())
                                    <img src="{{ asset('storage/' . $favorite->product->images->first()->ImageFileName) }}"
                                         class="card-img-top" alt="{{ $favorite->product->Name }}" style="height: 150px; object-fit: cover;">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">{{ $favorite->product ? Str::limit($favorite->product->Name, 20) : 'Producto no disponible' }}</h6>
                                    @if($favorite->product)
                                        <p class="card-text text-success mb-1">${{ number_format($favorite->product->Price, 2) }}</p>
                                        <a href="{{ route('shop.show', $favorite->product->ProductId) }}" class="btn btn-sm btn-outline-success">Ver</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No tienes productos favoritos aún.</p>
                        <a href="{{ route('shop.index') }}" class="btn btn-outline-danger">Explorar Productos</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
