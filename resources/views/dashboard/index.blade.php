@extends('layouts.app')

@section('title', 'Panel de Control - Sistema de Gestión')

@section('content')
<div class="dashboard">
    <h1>Panel de Control</h1>
    <p>Bienvenido al sistema de gestión. Selecciona una sección para administrar.</p>

    <div class="dashboard-section">
        <h2>Localización</h2>
        <div class="dashboard-cards">
            <a href="{{ route('countries.index') }}" class="dashboard-card">
                <h3>Países</h3>
                <p>Gestiona los países del sistema</p>
            </a>
            <a href="{{ route('entities.index') }}" class="dashboard-card">
                <h3>Entidades</h3>
                <p>Gestiona las entidades o estados</p>
            </a>
            <a href="{{ route('municipalities.index') }}" class="dashboard-card">
                <h3>Municipios</h3>
                <p>Gestiona los municipios o ciudades</p>
            </a>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>Usuarios y Roles</h2>
        <div class="dashboard-cards">
            <a href="{{ route('users.index') }}" class="dashboard-card">
                <h3>Usuarios</h3>
                <p>Administra los usuarios del sistema</p>
            </a>
            <a href="{{ route('roles.index') }}" class="dashboard-card">
                <h3>Roles</h3>
                <p>Gestiona los roles de usuario</p>
            </a>
            <a href="{{ route('addresses.index') }}" class="dashboard-card">
                <h3>Direcciones</h3>
                <p>Administra las direcciones de usuarios</p>
            </a>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>Catálogo</h2>
        <div class="dashboard-cards">
            <a href="{{ route('categories.index') }}" class="dashboard-card">
                <h3>Categorías</h3>
                <p>Gestiona las categorías de productos</p>
            </a>
            <a href="{{ route('products.index') }}" class="dashboard-card">
                <h3>Productos</h3>
                <p>Administra el catálogo de productos</p>
            </a>
            <a href="{{ route('product-inventories.index') }}" class="dashboard-card">
                <h3>Inventarios</h3>
                <p>Gestiona el inventario de productos</p>
            </a>
            <a href="{{ route('sizes.index') }}" class="dashboard-card">
                <h3>Tallas</h3>
                <p>Administra las tallas disponibles</p>
            </a>
            <a href="{{ route('images.index') }}" class="dashboard-card">
                <h3>Imágenes</h3>
                <p>Gestiona las imágenes de productos</p>
            </a>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>Proveedores</h2>
        <div class="dashboard-cards">
            <a href="{{ route('providers.index') }}" class="dashboard-card">
                <h3>Proveedores</h3>
                <p>Administra los proveedores</p>
            </a>
            <a href="{{ route('provider-details.index') }}" class="dashboard-card">
                <h3>Detalles de Proveedor</h3>
                <p>Gestiona detalles de proveedores</p>
            </a>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>Ventas</h2>
        <div class="dashboard-cards">
            <a href="{{ route('cart-items.index') }}" class="dashboard-card">
                <h3>Carritos</h3>
                <p>Administra los ítems en carritos</p>
            </a>
            <a href="{{ route('orders.index') }}" class="dashboard-card">
                <h3>Pedidos</h3>
                <p>Gestiona los pedidos realizados</p>
            </a>
            <a href="{{ route('order-details.index') }}" class="dashboard-card">
                <h3>Detalles de Pedido</h3>
                <p>Administra los detalles de pedidos</p>
            </a>
            <a href="{{ route('payments.index') }}" class="dashboard-card">
                <h3>Pagos</h3>
                <p>Gestiona los pagos realizados</p>
            </a>
        </div>
    </div>

    <div class="dashboard-section">
        <h2>Interacción</h2>
        <div class="dashboard-cards">
            <a href="{{ route('favorites.index') }}" class="dashboard-card">
                <h3>Favoritos</h3>
                <p>Administra los favoritos de usuarios</p>
            </a>
            <a href="{{ route('reviews.index') }}" class="dashboard-card">
                <h3>Reseñas</h3>
                <p>Gestiona las reseñas de productos</p>
            </a>
        </div>
    </div>
</div>
@endsection
