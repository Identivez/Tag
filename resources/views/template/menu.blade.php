<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h1 align-self-center" href="{{ route('home') }}">
            TAG & SOLE
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between" id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('shop.index') }}">Tienda</a>
                    </li>


                    @auth
                        @if(Auth::user()->email === 'admin@test.com')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">Admin</a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <div class="d-lg-none flex-sm-fill mt-3 mb-4 col-7 col-sm-auto pr-3">
                    <div class="input-group">
                        <input type="text" class="form-control" id="inputMobileSearch" placeholder="Buscar...">
                        <div class="input-group-text">
                            <i class="fa fa-fw fa-search"></i>
                        </div>
                    </div>
                </div>
                <a class="nav-icon d-none d-lg-inline" href="#" data-bs-toggle="modal" data-bs-target="#templatemo_search">
                    <i class="fa fa-fw fa-search text-dark mr-2"></i>
                </a>

                @auth
                    <a class="nav-icon position-relative text-decoration-none" href="{{ route('cart.view') }}">
                        <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                        <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark" id="cart-count">
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

                    <div class="nav-item dropdown">
                        <a class="nav-icon position-relative text-decoration-none dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-fw fa-user text-dark mr-3"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('favorites.user') }}">Favoritos</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="GET" action="{{ route('logout') }}" class="d-inline">
                                    <button type="submit" class="dropdown-item border-0 bg-transparent">Cerrar Sesión</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-icon position-relative text-decoration-none" href="{{ route('login') }}">
                        <i class="fa fa-fw fa-user text-dark mr-3"></i>
                        <small class="text-dark">Ingresar</small>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
<!-- Close Header -->

<!-- Modal de Búsqueda -->
<div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="w-100 pt-1 mb-5 text-right">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <form action="{{ route('shop.search') }}" method="get" class="modal-content modal-body border-0 p-0">
            <div class="input-group mb-2">
                <input type="text" class="form-control" id="inputModalSearch" name="query" placeholder="Buscar productos...">
                <button type="submit" class="input-group-text bg-success text-light">
                    <i class="fa fa-fw fa-search text-white"></i>
                </button>
            </div>
        </form>
    </div>
</div>
