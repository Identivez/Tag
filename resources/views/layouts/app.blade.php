<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TAG & SOLE') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos adicionales -->
    @stack('styles')
    @yield('styles')

    <style>
        /* ========================================
           VARIABLES CSS
        ======================================== */
        :root {
            --primary-color: #28a745;
            --primary-hover: #218838;
            --primary-border: #1e7e34;
            --secondary-color: #6c757d;
            --dark-color: #343a40;
            --light-color: #f8f9fa;
            --white: #ffffff;
            --shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            --shadow-lg: 0 1rem 3rem rgba(0, 0, 0, 0.175);
            --border-radius: 0.375rem;
            --transition: all 0.15s ease-in-out;
        }

        /* ========================================
           ESTILOS GENERALES
        ======================================== */
        body {
            font-family: 'Figtree', sans-serif;
            line-height: 1.6;
            color: var(--dark-color);
        }

        /* ========================================
           NAVBAR STYLES
        ======================================== */
        .navbar-brand {
            font-weight: 800;
            font-size: 1.75rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            transition: var(--transition);
        }

        .navbar-brand:hover {
            color: var(--primary-hover) !important;
            transform: scale(1.05);
        }

        .navbar {
            padding: 1rem 0;
            box-shadow: var(--shadow);
        }

        .nav-link {
            font-weight: 500;
            padding: 0.75rem 1rem !important;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--primary-color) !important;
        }

        .nav-link.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545 !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-lg);
            border-radius: var(--border-radius);
            padding: 0.5rem 0;
        }

        .dropdown-item {
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background-color: rgba(40, 167, 69, 0.1);
            color: var(--primary-color);
        }

        /* Badge en carrito */
        .cart-badge {
            font-size: 0.75rem;
            min-width: 1.25rem;
            height: 1.25rem;
            line-height: 1.25rem;
            text-align: center;
        }

        /* ========================================
           BUTTONS
        ======================================== */
        .btn {
            font-weight: 500;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: var(--transition);
            border: none;
        }

        .btn-success {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            border-color: var(--primary-color);
            box-shadow: 0 0.125rem 0.25rem rgba(40, 167, 69, 0.25);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--primary-hover) 0%, var(--primary-border) 100%);
            border-color: var(--primary-border);
            transform: translateY(-1px);
            box-shadow: 0 0.25rem 0.5rem rgba(40, 167, 69, 0.3);
        }

        .btn-outline-success {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-success:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-1px);
        }

        /* ========================================
           ALERTS
        ======================================== */
        .alert {
            border: none;
            border-radius: var(--border-radius);
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--shadow);
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid var(--primary-color);
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        .alert-warning {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%);
            color: #856404;
            border-left: 4px solid #ffc107;
        }

        /* ========================================
           PRELOADER
        ======================================== */
        .preloader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--white) 0%, var(--light-color) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 1;
            transition: opacity 0.3s ease-out;
        }

        .preloader.fade-out {
            opacity: 0;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* ========================================
           SEARCH BOX
        ======================================== */
        .search-box {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(5px);
            z-index: 9998;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }

        .search-box.active {
            display: flex;
            opacity: 1;
        }

        .search-wrap {
            background: var(--white);
            padding: 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            max-width: 500px;
            width: 90%;
        }

        .search-input {
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            border: 2px solid #e9ecef;
            border-radius: var(--border-radius);
            width: 100%;
            outline: none;
            transition: var(--transition);
        }

        .search-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .close-button {
            position: absolute;
            top: 1rem;
            right: 1rem;
            color: var(--white);
            cursor: pointer;
            font-size: 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
        }

        .close-button:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        /* ========================================
           TABLES (Mejoradas)
        ======================================== */
        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
            color: var(--white);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.025em;
            padding: 1rem;
            border: none;
        }

        .table tbody tr {
            transition: var(--transition);
        }

        .table tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.05);
            transform: scale(1.001);
        }

        .table tbody td {
            padding: 1rem;
            vertical-align: middle;
            border-top: 1px solid #e9ecef;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.02);
        }

        /* Tabla responsive mejorada */
        .table-responsive {
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        /* ========================================
           CARDS
        ======================================== */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            overflow: hidden;
        }

        .card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .card-header {
            background: linear-gradient(135deg, var(--light-color) 0%, #e9ecef 100%);
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            padding: 1.25rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* ========================================
           FOOTER
        ======================================== */
        footer {
            background: linear-gradient(135deg, var(--dark-color) 0%, #212529 100%);
            margin-top: 3rem;
        }

        footer h5 {
            color: var(--primary-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        footer a {
            transition: var(--transition);
        }

        footer a:hover {
            color: var(--primary-color) !important;
            text-decoration: underline !important;
        }

        /* ========================================
           UTILITIES
        ======================================== */
        .text-success {
            color: var(--primary-color) !important;
        }

        .bg-success {
            background-color: var(--primary-color) !important;
        }

        .border-success {
            border-color: var(--primary-color) !important;
        }

        /* ========================================
           RESPONSIVE
        ======================================== */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }

            .nav-link {
                padding: 0.5rem !important;
            }

            .search-wrap {
                margin: 1rem;
                padding: 1.5rem;
            }

            .search-input {
                font-size: 1rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* ========================================
           ANIMACIONES
        ======================================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slideInRight {
            animation: slideInRight 0.6s ease-out;
        }

        /* ========================================
           BADGES Y LABELS
        ======================================== */
        .badge {
            font-weight: 500;
            padding: 0.5em 0.75em;
            border-radius: 0.5rem;
        }

        .badge-success {
            background-color: var(--primary-color);
            color: var(--white);
        }

        /* Form controls mejorados */
        .form-control, .form-select {
            border-radius: var(--border-radius);
            border: 2px solid #e9ecef;
            padding: 0.75rem 1rem;
            transition: var(--transition);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
    </style>
</head>

<body>
    <!-- ========================================
         PRELOADER
    ======================================== -->
    <div class="preloader" id="preloader">
        <div class="text-center">
            <div class="spinner-border text-success" role="status">
                <span class="visually-hidden">Cargando...</span>
            </div>
            <div class="mt-3">
                <h5 class="text-success">TAG & SOLE</h5>
                <p class="text-muted">Cargando tu experiencia...</p>
            </div>
        </div>
    </div>

    <!-- ========================================
         SEARCH BOX
    ======================================== -->
    <div class="search-box" id="searchBox">
        <div class="close-button" onclick="closeSearch()">
            <i class="fas fa-times"></i>
        </div>
        <div class="search-wrap">
            <h4 class="text-center mb-3 text-success">
                <i class="fas fa-search me-2"></i>Buscar Productos
            </h4>
            <form action="{{ route('shop.search') }}" method="get">
                <div class="input-group">
                    <input type="text"
                           class="search-input"
                           placeholder="¿Qué estás buscando?"
                           name="search"
                           autofocus>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-search me-2"></i>Buscar
                    </button>
                </div>
            </form>
            <p class="text-muted text-center mt-2 mb-0">
                <small>Presiona <kbd>Esc</kbd> para cerrar</small>
            </p>
        </div>
    </div>

    <!-- ========================================
         NAVIGATION
    ======================================== -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <!-- Brand -->
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-running me-2"></i>TAG & SOLE
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav"
                    aria-controls="navbarNav"
                    aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Main Navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="fas fa-home me-2"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index') }}">
                            <i class="fas fa-store me-2"></i>Tienda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="fas fa-tags me-2"></i>Categorías
                        </a>
                        <ul class="dropdown-menu">
                            @php
                                try {
                                    $categories = \App\Models\Category::all();
                                } catch (\Exception $e) {
                                    $categories = collect();
                                }
                            @endphp
                            @forelse($categories as $category)
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ route('shop.category', $category->CategoryId) }}">
                                        <i class="fas fa-tag me-2"></i>{{ $category->Name }}
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item text-muted">
                                        <i class="fas fa-exclamation-circle me-2"></i>
                                        No hay categorías disponibles
                                    </span>
                                </li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="fas fa-envelope me-2"></i>Contacto
                        </a>
                    </li>
                    @auth
                        @if(Auth::user()->email === 'admin@test.com')
                            <li class="nav-item">
                                <a class="nav-link text-danger" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-crown me-2"></i>Admin
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>

                <!-- Right Navigation -->
                <ul class="navbar-nav">
                    <!-- Search Button -->
                    <li class="nav-item">
                        <button class="btn btn-link nav-link border-0" onclick="openSearch()">
                            <i class="fas fa-search"></i>
                        </button>
                    </li>

                    @auth
                        <!-- Cart -->
                        <li class="nav-item">
                            <a class="nav-link position-relative" href="{{ route('cart.view') }}">
                                <i class="fas fa-shopping-cart"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success cart-badge">
                                    @php
                                        try {
                                            $cartCount = \App\Models\CartItem::where('UserId', Auth::id())->sum('Quantity') ?? 0;
                                        } catch (\Exception $e) {
                                            $cartCount = 0;
                                        }
                                    @endphp
                                    {{ $cartCount }}
                                </span>
                            </a>
                        </li>

                        <!-- User Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               href="#"
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                                <i class="fas fa-user me-2"></i>{{ Auth::user()->firstName }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        <i class="fas fa-shopping-bag me-2"></i>Mis Pedidos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('favorites.user') }}">
                                        <i class="fas fa-heart me-2"></i>Favoritos
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                        <i class="fas fa-user-cog me-2"></i>Mi Perfil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <!-- Login/Register -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-2"></i>Ingresar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="fas fa-user-plus me-2"></i>Registro
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- ========================================
         PAGE HEADER (OPCIONAL)
    ======================================== -->
    @hasSection('header')
        <header class="bg-white shadow-sm">
            <div class="container py-4">
                @yield('header')
            </div>
        </header>
    @endif

    <!-- ========================================
         MAIN CONTENT
    ======================================== -->
    <main class="animate-fadeInUp">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show m-3 animate-slideInRight" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>¡Éxito!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show m-3 animate-slideInRight" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>Error:</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show m-3 animate-slideInRight" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Atención:</strong> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Content -->
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <!-- ========================================
         FOOTER
    ======================================== -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <h5><i class="fas fa-running me-2"></i>TAG & SOLE</h5>
                    <p class="mb-3">Tu tienda de sneakers y moda urbana en Toluca, México. Encuentra los mejores estilos y las marcas más exclusivas.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h5>Navegación</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-light text-decoration-none">Inicio</a></li>
                        <li><a href="{{ route('shop.index') }}" class="text-light text-decoration-none">Tienda</a></li>
                        <li><a href="{{ route('contact') }}" class="text-light text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Mi Cuenta</h5>
                    <ul class="list-unstyled">
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="text-light text-decoration-none">Dashboard</a></li>
                            <li><a href="{{ route('orders.index') }}" class="text-light text-decoration-none">Mis Pedidos</a></li>
                            <li><a href="{{ route('favorites.user') }}" class="text-light text-decoration-none">Favoritos</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="text-light text-decoration-none">Iniciar Sesión</a></li>
                            <li><a href="{{ route('register') }}" class="text-light text-decoration-none">Crear Cuenta</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h5>Contacto</h5>
                    <address class="mb-0">
                        <i class="fas fa-map-marker-alt me-2"></i>Toluca, Estado de México<br>
                        <i class="fas fa-phone me-2"></i>+52 722 123 4567<br>
                        <i class="fas fa-envelope me-2"></i>info@tagsole.com
                    </address>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; {{ date('Y') }} TAG & SOLE. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <small class="text-muted">
                        Hecho con <i class="fas fa-heart text-danger"></i> en México
                    </small>
                </div>
            </div>
        </div>
    </footer>

    <!-- ========================================
         SCRIPTS
    ======================================== -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Scripts específicos -->
    @stack('scripts')
    @yield('scripts')

    <script>
        // ========================================
        // PRELOADER
        // ========================================
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('fade-out');
                setTimeout(() => {
                    preloader.style.display = 'none';
                }, 300);
            }
        });

        // ========================================
        // SEARCH FUNCTIONALITY
        // ========================================
        function openSearch() {
            const searchBox = document.getElementById('searchBox');
            searchBox.classList.add('active');
            // Focus en el input después de la animación
            setTimeout(() => {
                const searchInput = searchBox.querySelector('.search-input');
                if (searchInput) searchInput.focus();
            }, 300);
        }

        function closeSearch() {
            document.getElementById('searchBox').classList.remove('active');
        }

        // Close search with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeSearch();
            }
        });

        // Click outside to close search
        document.getElementById('searchBox').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSearch();
            }
        });

        // ========================================
        // ALERTS AUTO-HIDE
        // ========================================
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (bootstrap.Alert.getInstance(alert)) {
                    const bsAlert = bootstrap.Alert.getInstance(alert);
                    bsAlert.close();
                } else {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            });
        }, 5000);

        // ========================================
        // BOOTSTRAP COMPONENTS INITIALIZATION
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Initialize popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl);
            });

            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // ========================================
        // ENHANCED TABLE FUNCTIONALITY
        // ========================================

        // Add row hover effects and sorting capabilities
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced table interactions
            const tables = document.querySelectorAll('.table');
            tables.forEach(table => {
                // Add data attributes for better accessibility
                const rows = table.querySelectorAll('tbody tr');
                rows.forEach((row, index) => {
                    row.setAttribute('data-row-index', index);

                    // Add click handler for row selection (optional)
                    row.addEventListener('click', function(e) {
                        // Only if not clicking on a button or link
                        if (!e.target.closest('button, a, input, select')) {
                            this.classList.toggle('table-active');
                        }
                    });
                });

                // Make tables more responsive
                if (!table.closest('.table-responsive')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'table-responsive';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });
        });

        // ========================================
        // CART UPDATE FUNCTIONALITY
        // ========================================
        function updateCartCount() {
            fetch('/cart/count', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const cartBadge = document.querySelector('.cart-badge');
                if (cartBadge && data.count !== undefined) {
                    cartBadge.textContent = data.count;

                    // Add animation when count changes
                    cartBadge.classList.add('animate__animated', 'animate__pulse');
                    setTimeout(() => {
                        cartBadge.classList.remove('animate__animated', 'animate__pulse');
                    }, 1000);
                }
            })
            .catch(error => {
                console.log('Error updating cart count:', error);
            });
        }

        // ========================================
        // FORM ENHANCEMENTS
        // ========================================
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-resize textareas
            const textareas = document.querySelectorAll('textarea');
            textareas.forEach(textarea => {
                textarea.addEventListener('input', function() {
                    this.style.height = 'auto';
                    this.style.height = this.scrollHeight + 'px';
                });
            });

            // Form validation styling
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const invalidInputs = form.querySelectorAll(':invalid');
                    invalidInputs.forEach(input => {
                        input.classList.add('is-invalid');
                    });
                });
            });

            // Real-time validation feedback
            const inputs = document.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.checkValidity()) {
                        this.classList.remove('is-invalid');
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                        this.classList.add('is-invalid');
                    }
                });
            });
        });

        // ========================================
        // PERFORMANCE OPTIMIZATIONS
        // ========================================

        // Lazy load images
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        imageObserver.unobserve(img);
                    }
                });
            });

            document.querySelectorAll('img[data-src]').forEach(img => {
                imageObserver.observe(img);
            });
        }

        // ========================================
        // UTILITY FUNCTIONS
        // ========================================

        // Show loading state
        function showLoading(element) {
            const originalContent = element.innerHTML;
            element.dataset.originalContent = originalContent;
            element.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Cargando...';
            element.disabled = true;
        }

        // Hide loading state
        function hideLoading(element) {
            if (element.dataset.originalContent) {
                element.innerHTML = element.dataset.originalContent;
                delete element.dataset.originalContent;
            }
            element.disabled = false;
        }

        // Show toast notification
        function showToast(message, type = 'success', duration = 3000) {
            const toast = document.createElement('div');
            toast.className = `toast align-items-center text-white bg-${type} border-0 position-fixed top-0 end-0 m-3`;
            toast.style.zIndex = '9999';
            toast.setAttribute('role', 'alert');
            toast.setAttribute('aria-live', 'assertive');
            toast.setAttribute('aria-atomic', 'true');

            toast.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            `;

            document.body.appendChild(toast);

            const bsToast = new bootstrap.Toast(toast, { delay: duration });
            bsToast.show();

            // Remove from DOM after hiding
            toast.addEventListener('hidden.bs.toast', () => {
                toast.remove();
            });
        }

        // Confirm dialog with better styling
        function confirmAction(message, callback) {
            if (confirm(message)) {
                callback();
            }
        }

        // ========================================
        // ACCESSIBILITY IMPROVEMENTS
        // ========================================

        // Keyboard navigation for dropdowns
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                // Close dropdowns when tabbing away
                const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
                openDropdowns.forEach(dropdown => {
                    if (!dropdown.contains(e.target)) {
                        bootstrap.Dropdown.getInstance(dropdown.previousElementSibling)?.hide();
                    }
                });
            }
        });

        // Focus management for modals
        document.addEventListener('shown.bs.modal', function(e) {
            const modal = e.target;
            const focusableElements = modal.querySelectorAll(
                'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
            );
            if (focusableElements.length > 0) {
                focusableElements[0].focus();
            }
        });

        // ========================================
        // ERROR HANDLING
        // ========================================

        // Global error handler for AJAX requests
        window.addEventListener('unhandledrejection', function(e) {
            console.error('Unhandled promise rejection:', e.reason);
            showToast('Ha ocurrido un error inesperado. Por favor, intenta de nuevo.', 'error');
        });

        // Network error detection
        window.addEventListener('offline', function() {
            showToast('Conexión perdida. Verifica tu conexión a internet.', 'warning', 5000);
        });

        window.addEventListener('online', function() {
            showToast('Conexión restaurada.', 'success');
        });
    </script>
</body>
</html>
