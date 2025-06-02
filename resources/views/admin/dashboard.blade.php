@extends('template.master')

@section('contenido_central')
<div class="container py-5">
   <div class="row">
       <div class="col-md-12">
           <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
               <h2 class="h3 mb-3">¡Bienvenido, {{ Auth::user()->firstName }}!</h2>
               @if(Auth::user()->email === 'admin@test.com')
                   <p class="text-muted">Panel de administración de TAG & SOLE. Gestiona productos, usuarios, correos y revisa estadísticas del sistema.</p>
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
                   <!-- Dashboard principal -->


                   @if(Auth::user()->email === 'admin@test.com')
                       <!-- Menú específico para Admin -->

                       <!-- Dashboard avanzado para administradores -->
                       <li class="mb-2">
                           <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-danger">
                               <i class="fas fa-cogs me-2"></i>Dashboard Avanzado
                           </a>
                       </li>

                       <!-- Gestión de productos -->
                       <li class="mb-2">
                           <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-box me-2"></i>Gestionar Productos
                           </a>
                       </li>

                       <!-- Gestión de usuarios -->
                       <li class="mb-2">
                           <a href="{{ route('users.index') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-users me-2"></i>Gestionar Usuarios
                           </a>
                       </li>

                       <!-- Gestión de imágenes -->
                       <li class="mb-2">
                           <a href="{{ route('images.index') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-image me-2"></i>Gestión de Imágenes
                           </a>
                       </li>

                       <!-- Visualización de gráficas del sistema -->
                       <li class="mb-2">
                           <a href="{{ route('graficas.index') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-chart-pie me-2"></i>Ver Gráficas
                           </a>
                       </li>

                       <!-- Gestión de categorías de productos -->
                       <li class="mb-2">
                           <a href="{{ route('categories.index') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-tags me-2"></i>Categorías
                           </a>
                       </li>

                       <!-- Gestión de todos los pedidos del sistema -->
                       <li class="mb-2">
                           <a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-shopping-cart me-2"></i>Todos los Pedidos
                           </a>
                       </li>


<li class="mb-2">
    <a href="{{ url('/ubicacion') }}" class="text-decoration-none text-dark">
        <i class="fas fa-globe-americas me-2"></i>Ubicación Dinámica
    </a>
</li>
<li class="mb-2">
    <a href="{{ route('ajax.products.index') }}" class="text-decoration-none text-dark">
        <i class="fas fa-sync-alt me-2"></i>Gestión AJAX de Productos
    </a>
</li>

                       <!-- Sistema de envío de correos electrónicos -->
                       <li class="mb-2">
                           <a href="{{ route('admin.emails.form') }}" class="text-decoration-none text-info">
                               <i class="fas fa-envelope me-2"></i>Sistema de Correos
                           </a>
                       </li>
                       <li class="mb-2">
                           <a href="#crudCollapse" class="text-decoration-none text-dark" data-bs-toggle="collapse">
                               <i class="fas fa-database me-2"></i>CRUDs <i class="fas fa-chevron-down float-end"></i>
                           </a>
                           <ul id="crudCollapse" class="collapse ps-3 mt-2">
                               <li class="mb-1"><a href="{{ route('countries.index') }}" class="text-decoration-none text-dark">Países</a></li>
                               <li class="mb-1"><a href="{{ route('entities.index') }}" class="text-decoration-none text-dark">Entidades</a></li>
                               <li class="mb-1"><a href="{{ route('municipalities.index') }}" class="text-decoration-none text-dark">Municipios</a></li>
                               <li class="mb-1"><a href="{{ route('categories.index') }}" class="text-decoration-none text-dark">Categorías</a></li>
                               <li class="mb-1"><a href="{{ route('products.index') }}" class="text-decoration-none text-dark">Productos</a></li>
                               <li class="mb-1"><a href="{{ route('providers.index') }}" class="text-decoration-none text-dark">Proveedores</a></li>
                               <li class="mb-1"><a href="{{ route('sizes.index') }}" class="text-decoration-none text-dark">Tallas</a></li>
                               <li class="mb-1"><a href="{{ route('images.index') }}" class="text-decoration-none text-dark">Imágenes</a></li>
                               <li class="mb-1"><a href="{{ route('product-inventories.index') }}" class="text-decoration-none text-dark">Inventario</a></li>
                               <li class="mb-1"><a href="{{ route('provider-details.index') }}" class="text-decoration-none text-dark">Detalles Proveedor</a></li>
                               <li class="mb-1"><a href="{{ route('orders.index') }}" class="text-decoration-none text-dark">Pedidos</a></li>
                               <li class="mb-1"><a href="{{ route('order-details.index') }}" class="text-decoration-none text-dark">Detalles Pedido</a></li>
                               <li class="mb-1"><a href="{{ route('payments.index') }}" class="text-decoration-none text-dark">Pagos</a></li>
                               <li class="mb-1"><a href="{{ route('addresses.index') }}" class="text-decoration-none text-dark">Direcciones</a></li>
                               <li class="mb-1"><a href="{{ route('users.index') }}" class="text-decoration-none text-dark">Usuarios</a></li>
                               <li class="mb-1"><a href="{{ route('roles.index') }}" class="text-decoration-none text-dark">Roles</a></li>
                           </ul>
                       </li>
                   @else
                       <!-- Menú para usuarios normales -->

                       <!-- Página de inicio de la tienda -->
                       <li class="mb-2">
                           <a href="{{ route('home') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-home me-2"></i>Inicio
                           </a>
                       </li>

                       <!-- Lista de productos favoritos del usuario -->
                       <li class="mb-2">
                           <a href="{{ route('favorites.user') }}" class="text-decoration-none text-dark">
                               <i class="fas fa-heart me-2"></i>Favoritos
                           </a>
                       </li>

                       <!-- Carrito de compras del usuario -->
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
           @if(Auth::user()->email === 'admin@test.com')
               <!-- Dashboard para Admin -->

               <!-- Tarjetas de estadísticas rápidas -->
               <div class="row mb-4">
                   <!-- Total de usuarios registrados -->
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

                   <!-- Total de productos en el catálogo -->
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

                   <!-- Total de pedidos realizados -->
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

                   <!-- Ventas del mes actual -->
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
                       <!-- Reportes PDF -->
                       <div class="col-md-3 mb-2">
                           <!-- Reporte de productos en PDF para visualizar -->
                           <a href="{{ route('pdf.productos', 1) }}" class="btn btn-outline-primary w-100" target="_blank">
                               <i class="fas fa-file-alt me-2"></i>Reporte de Productos
                           </a>
                       </div>

                       <div class="col-md-3 mb-2">
                           <!-- Reporte de productos con stock bajo en PDF -->
                           <a href="{{ route('pdf.stock_bajo', 1) }}" class="btn btn-outline-danger w-100" target="_blank">
                               <i class="fas fa-exclamation-triangle me-2"></i>Stock Bajo
                           </a>
                       </div>

                       <div class="col-md-3 mb-2">
                           <!-- Reporte de usuarios y sus pedidos en PDF -->
                           <a href="{{ route('pdf.usuarios_pedidos', 1) }}" class="btn btn-outline-dark w-100" target="_blank">
                               <i class="fas fa-users me-2"></i>Usuarios y Pedidos
                           </a>
                       </div>

                       <div class="col-md-3 mb-2">
                           <!-- Reporte de productos agrupados por categoría en PDF -->
                           <a href="{{ route('pdf.productos_categoria', 1) }}" class="btn btn-outline-success w-100" target="_blank">
                               <i class="fas fa-layer-group me-2"></i>Productos por Categoría
                           </a>
                       </div>

                       <!-- Acciones de gestión -->
                       <div class="col-md-3 mb-2">
                           <!-- Crear nuevo producto -->
                           <a href="{{ route('products.create') }}" class="btn btn-success w-100">
                               <i class="fas fa-plus me-2"></i>Nuevo Producto
                           </a>
                       </div>



                       <div class="col-md-3 mb-2">
                           <!-- Crear nueva categoría -->
                           <a href="{{ route('categories.create') }}" class="btn btn-info w-100">
                               <i class="fas fa-tags me-2"></i>Nueva Categoría
                           </a>
                       </div>



                       <!-- Herramientas de comunicación y sistema -->
                       <div class="col-md-3 mb-2">
                           <!-- Enviar correo electrónico -->
                           <a href="{{ route('admin.emails.form') }}" class="btn btn-warning w-100">
                               <i class="fas fa-envelope me-2"></i>Enviar Correo
                           </a>
                       </div>

                       <div class="col-md-3 mb-2">
                           <!-- Generar reportes en PDF -->
                           <a href="{{ route('pdf.index') }}" class="btn btn-dark w-100">
                               <i class="fas fa-file-pdf me-2"></i>Generar PDF
                           </a>
                       </div>

                       <div class="col-md-3 mb-2">
                           <!-- Gestión de productos con AJAX -->
                           <a href="{{ route('ajax.products.index') }}" class="btn btn-outline-primary w-100">
                               <i class="fas fa-cogs me-2"></i>Gestión AJAX
                           </a>
                       </div>


                   </div>
               </div>

               <!-- Herramientas de Comunicación -->
               <div class="bg-white shadow-sm rounded p-4 mb-4">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h5 class="mb-0">
                           <i class="fas fa-envelope text-info me-2"></i>Sistema de Comunicación
                       </h5>
                       <span class="badge bg-info">{{ $totalUsers }} usuarios</span>
                   </div>

                   <div class="row">
                       <div class="col-md-6">
                           <!-- Panel de envío de correos -->
                           <div class="card border-info">
                               <div class="card-body text-center">
                                   <i class="fas fa-paper-plane fa-2x text-info mb-3"></i>
                                   <h6 class="card-title">Envío de Correos</h6>
                                   <p class="card-text text-muted small">
                                       Envía correos personalizados a usuarios, confirmaciones de pedidos y newsletters.
                                   </p>
                                   <a href="{{ route('admin.emails.form') }}" class="btn btn-info btn-sm">
                                       <i class="fas fa-envelope me-1"></i>Acceder
                                   </a>
                               </div>
                           </div>
                       </div>

                       <div class="col-md-6">
                           <!-- Panel de estadísticas de email -->
                           <div class="card border-secondary">
                               <div class="card-body text-center">
                                   <i class="fas fa-chart-line fa-2x text-secondary mb-3"></i>
                                   <h6 class="card-title">Estadísticas Email</h6>
                                   <p class="card-text text-muted small">
                                       Revisa estadísticas de envíos, aperturas y efectividad de campañas.
                                   </p>
                                   <a href="{{ route('admin.emails.history') }}" class="btn btn-secondary btn-sm">
                                       <i class="fas fa-chart-bar me-1"></i>Ver Stats
                                   </a>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>

               <!-- Pedidos recientes para Admin -->
               <div class="bg-white shadow-sm rounded p-4">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h5 class="mb-0">Pedidos Recientes del Sistema</h5>
                       <div>
                           <!-- Ver todos los pedidos -->
                           <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary me-2">Ver Todos</a>

                           <!-- Dropdown para opciones de correo -->
                           <div class="btn-group" role="group">
                               <button type="button" class="btn btn-sm btn-outline-info dropdown-toggle" data-bs-toggle="dropdown">
                                   <i class="fas fa-envelope me-1"></i>Correos
                               </button>
                               <ul class="dropdown-menu">
                                   <!-- Enviar confirmaciones masivas -->
                                   <li><a class="dropdown-item" href="#" onclick="sendBulkConfirmations()">
                                       <i class="fas fa-paper-plane me-2"></i>Enviar Confirmaciones
                                   </a></li>
                                   <!-- Correo personalizado -->
                                   <li><a class="dropdown-item" href="{{ route('admin.emails.form') }}">
                                       <i class="fas fa-edit me-2"></i>Correo Personalizado
                                   </a></li>
                               </ul>
                           </div>
                       </div>
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
                                           <div class="btn-group" role="group">
                                               <!-- Ver detalles del pedido -->
                                               <a href="{{ route('orders.show', $order->OrderId) }}" class="btn btn-sm btn-outline-primary">
                                                   <i class="fas fa-eye"></i>
                                               </a>
                                               <!-- Enviar confirmación individual por email -->
                                               <button type="button" class="btn btn-sm btn-outline-info"
                                                       onclick="sendOrderConfirmation({{ $order->OrderId }})"
                                                       title="Enviar confirmación por email">
                                                   <i class="fas fa-envelope"></i>
                                               </button>
                                           </div>
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
               <!-- Dashboard para usuarios normales -->

               <!-- Estadísticas del usuario -->
               <div class="row mb-4">
                   <!-- Pedidos realizados por el usuario -->
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

                   <!-- Productos favoritos del usuario -->
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

                   <!-- Items en el carrito del usuario -->
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
                       <!-- Enlace para ir a la tienda -->
                       <a href="{{ route('shop.index') }}" class="btn btn-sm btn-outline-success">Ver Tienda</a>
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
                                           <!-- Ver confirmación del pedido -->
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
                           <!-- Enlace para explorar productos -->
                           <a href="{{ route('shop.index') }}" class="btn btn-success">Explorar Productos</a>
                       </div>
                   @endif
               </div>

               <!-- Productos favoritos recientes del usuario -->
               <div class="bg-white shadow-sm rounded p-4">
                   <div class="d-flex justify-content-between align-items-center mb-3">
                       <h5 class="mb-0">Productos Favoritos</h5>
                       <!-- Ver todos los favoritos -->
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
                                           <!-- Ver producto individual -->
                                           <a href="{{ route('shop.product', $product->ProductId) }}" class="btn btn-sm btn-outline-success">Ver</a>
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
                           <!-- Enlace para explorar productos -->
                           <a href="{{ route('shop.index') }}" class="btn btn-outline-danger">Explorar Productos</a>
                       </div>
                   @endif
               </div>
           @endif
       </div>
   </div>
</div>

<!-- JavaScript para funcionalidades de email -->
<script>
   // Función para enviar confirmación de pedido individual
   function sendOrderConfirmation(orderId) {
       if (confirm('¿Enviar confirmación por email para el pedido #' + orderId + '?')) {
           fetch(`/admin/emails/order-confirmation/${orderId}`, {
               method: 'POST',
               headers: {
                   'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                   'Content-Type': 'application/json',
               },
           })
           .then(response => response.json())
           .then(data => {
               if (data.success) {
                   alert('Confirmación enviada correctamente');
               } else {
                   alert('Error al enviar confirmación: ' + data.message);
               }
           })
           .catch(error => {
               console.error('Error:', error);
               alert('Error al enviar confirmación');
           });
       }
   }

   // Función para enviar confirmaciones masivas (placeholder)
   function sendBulkConfirmations() {
       if (confirm('¿Enviar confirmaciones por email a todos los pedidos pendientes?')) {
           alert('Función de envío masivo - Implementar según necesidades específicas');
           // Aquí se implementaría la lógica de envío masivo
       }
   }
</script>
@endsection
