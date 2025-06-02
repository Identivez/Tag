@extends('template.master')

@section('contenido_central')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <h2 class="h3 mb-3">¡Bienvenido, {{ Auth::user()->firstName }}!</h2>
                @if(Auth::user()->email === 'admin@test.com')
                    <p class="text-muted">Panel de administración de TAG & SOLE. Gestiona productos, usuarios y revisa estadísticas del sistema.</p>
                @else
                    <p class="text-muted">Gestiona tu cuenta, revisa tus pedidos y mantente al día con las últimas tendencias en TAG & SOLE.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Menú lateral -->
        <div class="col-md-3">
            <div class="bg-white shadow-sm rounded p-3 mb-4">
                <h5 class="border-bottom pb-2 mb-3">
                    @if(Auth::user()->email === 'admin@test.com')
                        Panel de Control
                    @else
                        Mi Cuenta
                    @endif
                </h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('dashboard') }}" class="text-decoration-none {{ request()->routeIs('dashboard') ? 'text-success fw-bold' : 'text-dark' }}">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>

                    @if(Auth::user()->isAdmin())
                        <!-- Menú específico para Admin -->
                        <li class="mb-2">
                            <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-danger">
                                <i class="fas fa-cogs me-2"></i>Dashboard Avanzado
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('productos.index') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-box me-2"></i>Gestionar Productos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-users me-2"></i>Gestionar Usuarios
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('categorias.index') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-tags me-2"></i>Categorías
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-shopping-cart me-2"></i>Todos los Pedidos
                            </a>
                        </li>
                        <li class="mb-2">
                            <a href="{{ route('admin.statistics') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-chart-bar me-2"></i>Estadísticas
                            </a>
                        </li>
                    @else
                        <!-- Menú para usuarios normales -->
                        <li class="mb-2">
                            <a href="{{ route('home') }}" class="text-decoration-none text-dark">
                                <i class="fas fa-home me-2"></i>Inicio
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
                    @endif
                </ul>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-9">
            @if(Auth::user()->isAdmin())
                <!-- Dashboard para Admin -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="bg-white shadow-sm rounded p-3 text-center">
                            <div class="text-primary">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            @php
                                $totalUsers = 0;
                                try {
                                    $totalUsers = \App\Models\User::count();
                                } catch (\Exception $e) {
                                    // Si hay error, mantener en 0
                                }
                            @endphp
                            <h4 class="mt-2">{{ $totalUsers }}</h4>
                            <p class="text-muted mb-0">Total Usuarios</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white shadow-sm rounded p-3 text-center">
                            <div class="text-success">
                                <i class="fas fa-box fa-2x"></i>
                            </div>
                            @php
                                $totalProducts = 0;
                                try {
                                    $totalProducts = \App\Models\Product::count();
                                } catch (\Exception $e) {
                                    // Si hay error, mantener en 0
                                }
                            @endphp
                            <h4 class="mt-2">{{ $totalProducts }}</h4>
                            <p class="text-muted mb-0">Total Productos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white shadow-sm rounded p-3 text-center">
                            <div class="text-warning">
                                <i class="fas fa-shopping-bag fa-2x"></i>
                            </div>
                            @php
                                $totalOrders = 0;
                                try {
                                    $totalOrders = \App\Models\Order::count();
                                } catch (\Exception $e) {
                                    // Si hay error, mantener en 0
                                }
                            @endphp
                            <h4 class="mt-2">{{ $totalOrders }}</h4>
                            <p class="text-muted mb-0">Total Pedidos</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="bg-white shadow-sm rounded p-3 text-center">
                            <div class="text-danger">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                            @php
                                $monthlySales = 0;
                                try {
                                    $monthlySales = \App\Models\Order::whereMonth('OrderDate', now()->month)
                                        ->whereYear('OrderDate', now()->year)
                                        ->sum('TotalAmount') ?? 0;
                                } catch (\Exception $e) {
                                    // Si hay error, mantener en 0
                                }
                            @endphp
                            <h4 class="mt-2">${{ number_format($monthlySales, 0) }}</h4>
                            <p class="text-muted mb-0">Ventas del Mes</p>
                        </div>
                    </div>
                </div>

                <!-- Acciones rápidas para Admin -->
                <div class="bg-white shadow-sm rounded p-4 mb-4">
                    <h5 class="mb-3">Acciones Rápidas</h5>
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('productos.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>Nuevo Producto
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('users.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('categorias.create') }}" class="btn btn-info w-100">
                                <i class="fas fa-tags me-2"></i>Nueva Categoría
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('admin.reports') }}" class="btn btn-secondary w-100">
                                <i class="fas fa-chart-line me-2"></i>Ver Reportes
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Pedidos recientes para Admin -->
                <div class="bg-white shadow-sm rounded p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Pedidos Recientes del Sistema</h5>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                    </div>

                    @php
                        $recentOrders = collect();
                        try {
                            $recentOrders = \App\Models\Order::orderBy('OrderDate', 'desc')
                                ->take(5)
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
                                        <th>Usuario</th>
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
                                        <td>
                                            @php
                                                $user = null;
                                                try {
                                                    $user = \App\Models\User::find($order->UserId);
                                                } catch (\Exception $e) {
                                                    // Si hay error, user será null
                                                }
                                            @endphp
                                            {{ $user ? $user->firstName . ' ' . $user->lastName : 'Usuario no encontrado' }}
                                        </td>
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
                                            <a href="{{ route('orders.show', $order->OrderId) }}" class="btn btn-sm btn-outline-primary">Ver</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay pedidos en el sistema aún.</p>
                        </div>
                    @endif
                </div>

            @else
                <!-- Dashboard para usuarios normales (código original) -->
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

                <!-- Pedidos recientes del usuario -->
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

                <!-- Productos favoritos recientes del usuario -->
                <div class="bg-white shadow-sm rounded p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">Productos Favoritos</h5>
                        <a href="{{ route('favorites.user') }}" class="btn btn-sm btn-outline-danger">Ver Todos</a>
                    </div>

                    @php
                        $recentFavorites = collect();
                        try {
                            $recentFavorites = \App\Models\Favorite::where('UserId', Auth::id())
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
                                    @php
                                        $product = null;
                                        try {
                                            $product = \App\Models\Product::find($favorite->ProductId);
                                        } catch (\Exception $e) {
                                            // Si hay error, product será null
                                        }
                                    @endphp

                                    @if($product)
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1">{{ Str::limit($product->Name, 20) }}</h6>
                                            <p class="card-text text-success mb-1">${{ number_format($product->Price ?? 0, 2) }}</p>
                                            <a href="{{ route('shop.show', $product->ProductId) }}" class="btn btn-sm btn-outline-success">Ver</a>
                                        </div>
                                    @else
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 150px;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                        <div class="card-body p-2">
                                            <h6 class="card-title mb-1">Producto no disponible</h6>
                                        </div>
                                    @endif
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
            @endif
        </div>
    </div>
</div>
@endsection
