<!DOCTYPE html>
<html lang="es">

<head>
    <title>TAG & SOLE - Tienda de Sneakers y Moda Urbana</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="{{ asset('estilo/assets/img/apple-icon.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('estilo/assets/img/favicon.ico') }}">

    <link rel="stylesheet" href="{{ asset('estilo/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('estilo/assets/css/templatemo.css') }}">
    <link rel="stylesheet" href="{{ asset('estilo/assets/css/custom.css') }}">

    <!-- Cargar fuentes después de los estilos del layout -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;200;300;400;500;700;900&display=swap">
    <link rel="stylesheet" href="{{ asset('estilo/assets/css/fontawesome.min.css') }}">

    @yield('styles')
</head>

<body>
    <!-- Start Top Nav -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-light d-none d-lg-block" id="templatemo_nav_top">
        <div class="container text-light">
            <div class="w-100 d-flex justify-content-between">
                <div>
                    <i class="fa fa-envelope mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="mailto:info@tagsole.com">info@tagsole.com</a>
                    <i class="fa fa-phone mx-2"></i>
                    <a class="navbar-sm-brand text-light text-decoration-none" href="tel:+52-722-123-4567">+52 722 123 4567</a>
                </div>

            </div>
        </div>
    </nav>
    <!-- Close Top Nav -->
