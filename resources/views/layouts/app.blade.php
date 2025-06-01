<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sneakers Market') }}</title>

    <!-- Estilos originales -->
    <link rel="stylesheet" href="{{ asset('css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style.css') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,900;1,900&family=Source+Sans+Pro:wght@400;600;700;900&display=swap" rel="stylesheet">

    <!-- Scripts y estilos de Breeze -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Estilos específicos de la página -->
    @stack('styles')
</head>
<body>
    <!-- SVG sprites (copia del original) -->
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
      <symbol xmlns="http://www.w3.org/2000/svg" id="shopping-carriage" viewBox="0 0 24 24" fill="none">
        <path d="M5 22H19C20.103 22 21 21.103 21 20V9C21 8.73478 20.8946 8.48043 20.7071 8.29289C20.5196 8.10536 20.2652 8 20 8H17V7C17 4.243 14.757 2 12 2C9.243 2 7 4.243 7 7V8H4C3.73478 8 3.48043 8.10536 3.29289 8.29289C3.10536 8.48043 3 8.73478 3 9V20C3 21.103 3.897 22 5 22ZM9 7C9 5.346 10.346 4 12 4C13.654 4 15 5.346 15 7V8H9V7ZM5 10H7V12H9V10H15V12H17V10H19L19.002 20H5V10Z" fill="black" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="quick-view" viewBox="0 0 24 24">
        <path fill="currentColor" d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396l1.414-1.414l-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8s3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6s-6-2.691-6-6s2.691-6 6-6z" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="shopping-cart" viewBox="0 0 24 24" fill="none">
        <path d="M21 4H2V6H4.3L7.582 15.025C7.79362 15.6029 8.1773 16.1021 8.68134 16.4552C9.18539 16.8083 9.78556 16.9985 10.401 17H19V15H10.401C9.982 15 9.604 14.735 9.461 14.342L8.973 13H18.246C19.136 13 19.926 12.402 20.169 11.549L21.962 5.275C22.0039 5.12615 22.0109 4.96962 21.9823 4.81763C21.9537 4.66565 21.8904 4.52234 21.7973 4.39889C21.7041 4.27544 21.5837 4.1752 21.4454 4.106C21.3071 4.0368 21.1546 4.00053 21 4ZM18.246 11H8.246L6.428 6H19.675L18.246 11Z" fill="black" />
        <path d="M10.5 21C11.3284 21 12 20.3284 12 19.5C12 18.6716 11.3284 18 10.5 18C9.67157 18 9 18.6716 9 19.5C9 20.3284 9.67157 21 10.5 21Z" fill="black" />
        <path d="M16.5 21C17.3284 21 18 20.3284 18 19.5C18 18.6716 17.3284 18 16.5 18C15.6716 18 15 18.6716 15 19.5C15 20.3284 15.6716 21 16.5 21Z" fill="black" />
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="close" viewBox="0 0 24 24">
        <path fill="currentColor" d="m16.192 6.344-4.243 4.242-4.242-4.242-1.414 1.414L10.535 12l-4.242 4.242 1.414 1.414 4.242-4.242 4.243 4.242 1.414-1.414L13.364 12l4.242-4.242z"/>
      </symbol>
      <symbol xmlns="http://www.w3.org/2000/svg" id="search" viewBox="0 0 24 24">
        <path fill="currentColor" d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/>
      </symbol>
      <!-- Aseguramos que todos los símbolos SVG necesarios estén definidos -->
    </svg>

    <!-- Preloader -->
    <div class="preloader" style="position: fixed;top:0;left:0;width: 100%;height: 100%;background-color: #fff;display: flex;align-items: center;justify-content: center;z-index: 9999;">
        <svg version="1.1" id="L4" width="100" height="100" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
        viewBox="0 0 50 100" enable-background="new 0 0 0 0" xml:space="preserve">
            <circle fill="#000" stroke="none" cx="25" cy="30" r="6">
                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.1"/>
            </circle>
            <circle fill="#000" stroke="none" cx="25" cy="50" r="6">
                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.2"/>
            </circle>
            <circle fill="#000" stroke="none" cx="25" cy="70" r="6">
                <animate attributeName="opacity" dur="1s" values="0;1;0" repeatCount="indefinite" begin="0.3"/>
            </circle>
        </svg>
    </div>

    <!-- Search box -->
    <div class="search-box bg-dark position-relative">
        <div class="search-wrap">
            <div class="close-button">
                <svg class="close" style="fill: white;">
                    <use xlink:href="#close"></use>
                </svg>
            </div>
            <form id="search-form" class="text-lg-center text-md-left pt-3" action="{{ route('home') }}" method="get">
                <input type="text" class="search-input" placeholder="Search..." name="query">
                <svg class="search">
                    <use xlink:href="#search"></use>
                </svg>
            </form>
        </div>
    </div>

    <!-- Incluir los modales (importante para la funcionalidad de carrito, login, etc.) -->
    @include('partials.modals')

    <!-- Incluir header/navbar -->
    @include('partials.navbar')

    <!-- Contenido principal - Esta sección es fundamental para la visualización de las vistas que extienden este layout -->
    <main>
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot ?? '' }}
        @endif
    </main>

    <!-- Incluir footer -->
    @include('partials.footer')

    <!-- Scripts originales - Necesarios para la funcionalidad del sitio -->
    <script src="{{ asset('js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('js/plugins.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>

    <!-- Scripts específicos de la página - Permite a las vistas individuales añadir sus propios scripts -->
    @stack('scripts')

    <!-- Script para resolver posibles conflictos de nombres con 'role' -->
    <script>
        // Este script ayuda a prevenir cualquier problema de resolución de nombres con 'role'
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializamos los componentes del sitio
            if (typeof initComponents === 'function') {
                initComponents();
            }
        });
    </script>
</body>
</html>
