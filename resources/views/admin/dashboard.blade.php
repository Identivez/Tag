<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .card-stat {
            border-left: 4px solid #007bff;
        }
        .card-stat.success {
            border-left-color: #28a745;
        }
        .card-stat.warning {
            border-left-color: #ffc107;
        }
        .card-stat.danger {
            border-left-color: #dc3545;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-store"></i> Mi Sistema
            </a>

            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user"></i> {{ auth()->user()->firstName }} {{ auth()->user()->lastName }}
                        @if(auth()->user()->email === 'admin@test.com')
                            <span class="badge bg-danger ms-1">Admin</span>
                        @elseif(auth()->user()->email === 'manager@test.com')
                            <span class="badge bg-warning ms-1">Manager</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user-cog"></i> Mi Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-12">
                <h1 class="h3 mb-4">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                    @if(auth()->user()->email === 'admin@test.com')
                        - Panel de Administración
                    @elseif(auth()->user()->email === 'manager@test.com')
                        - Panel de Manager
                    @else
                        - Panel de Usuario
                    @endif
                </h1>
            </div>
        </div>

        <!-- Tarjetas de estadísticas (solo para admin/manager) -->
        @if(auth()->user()->email === 'admin@test.com' || auth()->user()->email === 'manager@test.com')
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card card-stat border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small">Usuarios</div>
                                <div class="h5 mb-0">{{ $userCount ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-stat success border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-shopping-cart fa-2x text-success"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small">Pedidos</div>
                                <div class="h5 mb-0">{{ $orderCount ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-stat warning border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-box fa-2x text-warning"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small">Productos</div>
                                <div class="h5 mb-0">{{ $productCount ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="card card-stat danger border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-dollar-sign fa-2x text-danger"></i>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="text-muted small">Ventas Mes</div>
                                <div class="h5 mb-0">${{ number_format($monthlySales ?? 0, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Módulos de navegación -->
        <div class="row">
            <!-- Módulos básicos para todos los usuarios -->
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-shopping-bag"></i> E-commerce</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('cart.view') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-shopping-cart"></i> Mi Carrito
                            </a>
                            <a href="{{ route('favorites.user') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-heart"></i> Mis Favoritos
                            </a>
                            <a href="{{ route('orders.user') }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-list-alt"></i> Mis Pedidos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Módulos para Manager -->
            @if(auth()->user()->email === 'manager@test.com' || auth()->user()->email === 'admin@test.com')
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="card-title mb-0"><i class="fas fa-cogs"></i> Gestión (Manager)</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('categorias.index') }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-tags"></i> Categorías
                            </a>
                            <a href="{{ route('productos.index') }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-box"></i> Productos
                            </a>
                            <a href="{{ route('paises.index') }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-globe"></i> Ubicaciones
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Módulos solo para Admin -->
            @if(auth()->user()->email === 'admin@test.com')
            <div class="col-lg-4 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-danger text-white">
                        <h5 class="card-title mb-0"><i class="fas fa-user-shield"></i> Administración</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('users.index') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-users"></i> Usuarios
                            </a>
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-user-tag"></i> Roles
                            </a>
                            <a href="{{ route('admin.statistics') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-chart-bar"></i> Estadísticas
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Acciones rápidas (para admin/manager) -->
        @if(auth()->user()->email === 'admin@test.com' || auth()->user()->email === 'manager@test.com')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="fas fa-bolt"></i> Acciones Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <a href="{{ route('productos.create') }}" class="btn btn-success w-100">
                                    <i class="fas fa-plus"></i> Nuevo Producto
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('categorias.create') }}" class="btn btn-info w-100">
                                    <i class="fas fa-plus"></i> Nueva Categoría
                                </a>
                            </div>
                            @if(auth()->user()->email === 'admin@test.com')
                            <div class="col-md-3">
                                <a href="{{ route('users.create') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-user-plus"></i> Nuevo Usuario
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('pdf.index') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-file-pdf"></i> Reportes PDF
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Información de bienvenida para usuarios normales -->
        @if(auth()->user()->email !== 'admin@test.com' && auth()->user()->email !== 'manager@test.com')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <h3><i class="fas fa-smile"></i> ¡Bienvenido {{ auth()->user()->firstName }}!</h3>
                        <p class="lead">Explora nuestros productos y gestiona tus compras desde aquí.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-shopping-bag"></i> Ir a la Tienda
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
