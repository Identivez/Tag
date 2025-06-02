<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\ProductAjaxController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Controllers\ProviderDetailController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ==========================================
// RUTAS PÚBLICAS
// ==========================================

// Página de inicio
Route::get('/', [ShopController::class, 'index'])->name('home');

// Rutas públicas de la tienda
Route::prefix('tienda')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/producto/{product}', [ShopController::class, 'show'])->name('show');
    Route::get('/categoria/{category}', [ShopController::class, 'byCategory'])->name('category');
    Route::get('/buscar', [ShopController::class, 'search'])->name('search');
});

// Rutas de contacto y email
Route::get('/contacto', [EmailController::class, 'showContactForm'])->name('contact');
Route::post('/contacto', [EmailController::class, 'sendContactEmail'])->name('contact.send');

// Newsletter
Route::post('/newsletter/suscribir', function() {
    return redirect()->back()->with('success', 'Te has suscrito exitosamente al newsletter.');
})->name('newsletter.subscribe');

// Rutas AJAX públicas (países->entidades->municipios)
Route::prefix('ajax')->group(function () {
    Route::get('/entidades/{id_pais}', [AjaxController::class, 'cambia_combo']);
    Route::get('/municipios/{id_entidad}', [AjaxController::class, 'cambia_combo_2']);
});

// ==========================================
// RUTAS DE AUTENTICACIÓN (SIN BREEZE)
// ==========================================

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout']);

// ==========================================
// RUTAS PROTEGIDAS POR AUTENTICACIÓN
// ==========================================

Route::middleware('auth')->group(function () {

    // Dashboard general (ÚNICO dashboard route)
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // ==========================================
    // RUTAS DE PERFIL DE USUARIO
    // ==========================================

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ==========================================
    // RUTAS DE USUARIO NORMAL
    // ==========================================

    // Carrito de compras
    Route::prefix('carrito')->name('cart.')->group(function () {
        Route::get('/', [CartItemController::class, 'viewCart'])->name('view');
        Route::post('/agregar', [CartItemController::class, 'addToCart'])->name('add');
        Route::patch('/actualizar/{cartId}', [CartItemController::class, 'updateQuantity'])->name('update');
        Route::delete('/eliminar/{cartId}', [CartItemController::class, 'removeFromCart'])->name('remove');
        Route::delete('/vaciar', [CartItemController::class, 'clearCart'])->name('clear');
    });

    // Favoritos
    Route::prefix('favoritos')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'userFavorites'])->name('user');
        Route::post('/toggle', [FavoriteController::class, 'toggleFavorite'])->name('toggle');
        Route::get('/check/{productId}', [FavoriteController::class, 'checkFavorite'])->name('check');
        Route::delete('/eliminar-multiple', [FavoriteController::class, 'bulkRemove'])->name('bulk-remove');
    });

    // Pedidos de usuario
    Route::prefix('pedidos')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'userOrders'])->name('user');
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/realizar', [OrderController::class, 'placeOrder'])->name('place');
        Route::get('/confirmacion/{orderId}', [OrderController::class, 'confirmation'])->name('confirmation');
        Route::patch('/cancelar/{orderId}', [OrderController::class, 'cancelOrder'])->name('cancel');
    });

    // Reseñas
    Route::post('/reseñas', [ReviewController::class, 'store'])->name('reviews.store');

    // ==========================================
    // RUTAS PARA MANAGER (manager@test.com)
    // ==========================================

    Route::middleware('role:manager')->group(function () {
        // Gestión de ubicaciones geográficas (solo managers)
        Route::resource('paises', CountryController::class);
        Route::resource('entidades', EntityController::class);
        Route::resource('municipios', MunicipalityController::class);

        // Gestión básica de productos (managers pueden gestionar productos)
        Route::resource('categorias', CategoryController::class);
        Route::resource('productos', ProductController::class);
        Route::resource('proveedores', ProviderController::class);
    });

    // ==========================================
    // RUTAS SOLO PARA ADMIN (admin@test.com)
    // ==========================================

    Route::middleware('role:admin')->group(function () {

        // Dashboard de administrador específico
        Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::get('/admin/estadisticas', [AdminController::class, 'statistics'])->name('admin.statistics');
        Route::get('/admin/reportes', [AdminController::class, 'reports'])->name('admin.reports');

        // Gestión de usuarios y roles (SOLO ADMIN)
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);

        // Gestión completa del catálogo (ADMIN tiene acceso total)
        Route::resource('categorias', CategoryController::class);
        Route::resource('productos', ProductController::class);
        Route::resource('proveedores', ProviderController::class);
        Route::resource('tallas', SizeController::class);
        Route::resource('imagenes', ImageController::class);

        // Gestión de ubicaciones geográficas (ADMIN también)
        Route::resource('countries', CountryController::class);
        Route::resource('entities', EntityController::class);
        Route::resource('municipalities', MunicipalityController::class);

        // Gestión de inventario y stock
        Route::resource('product-inventories', ProductInventoryController::class);
        Route::resource('provider-details', ProviderDetailController::class);

        // Gestión de pedidos y ventas (vista admin)
        Route::resource('orders', OrderController::class);
        Route::resource('order-details', OrderDetailController::class);
        Route::resource('payments', PaymentController::class);

        // Gestión de clientes
        Route::resource('addresses', AddressController::class);
        Route::resource('reviews', ReviewController::class);
        Route::resource('favorites', FavoriteController::class);
        Route::resource('cart-items', CartItemController::class);

        // ==========================================
        // RUTAS AJAX PARA ADMINISTRADOR
        // ==========================================

        Route::prefix('ajax')->name('ajax.')->group(function () {
            // Gestión de productos con AJAX
            Route::get('/productos', [ProductAjaxController::class, 'index'])->name('productos.index');
            Route::get('/productos/categoria/{categoryId}', [ProductAjaxController::class, 'buscarProductos'])->name('productos.categoria');
            Route::get('/productos/proveedor/{providerId}', [ProductAjaxController::class, 'buscarProductosPorProveedor'])->name('productos.proveedor');
            Route::post('/productos/{productId}/incrementar-stock/{categoryId}', [ProductAjaxController::class, 'incrementarStock'])->name('productos.incrementar');
            Route::post('/productos/{productId}/decrementar-stock/{categoryId}', [ProductAjaxController::class, 'decrementarStock'])->name('productos.decrementar');
            Route::get('/productos/{productId}/obtener', [ProductAjaxController::class, 'obtenerProducto'])->name('productos.obtener');
            Route::put('/productos/{productId}/actualizar', [ProductAjaxController::class, 'actualizarProducto'])->name('productos.actualizar');

            // Gestión de ubicaciones con AJAX
            Route::get('/ubicaciones', [LocationController::class, 'index'])->name('ubicaciones.index');
            Route::get('/ubicaciones/entidades/{countryId}', [LocationController::class, 'getEntities'])->name('ubicaciones.entidades');
            Route::get('/ubicaciones/municipios/{entityId}', [LocationController::class, 'getMunicipalities'])->name('ubicaciones.municipios');
            Route::get('/ubicaciones/municipio/{municipalityId}', [LocationController::class, 'getMunicipalityDetails'])->name('ubicaciones.municipio.detalles');
            Route::put('/ubicaciones/municipio/{municipalityId}/estado', [LocationController::class, 'updateMunicipalityStatus'])->name('ubicaciones.municipio.estado');
            Route::get('/ubicaciones/datos-dinamicos', [LocationController::class, 'dynamicData'])->name('ubicaciones.dinamicos');
            Route::get('/ubicaciones/entidad/{entityId}', [LocationController::class, 'getEntityDetails'])->name('ubicaciones.entidad.detalles');
            Route::put('/ubicaciones/entidad/{entityId}/nombre', [LocationController::class, 'updateEntityName'])->name('ubicaciones.entidad.nombre');
        });

        // Rutas de email administrativas
        Route::prefix('email')->name('email.')->group(function () {
            Route::post('/confirmacion-pedido/{orderId}', [EmailController::class, 'sendOrderConfirmation'])->name('order.confirmation');
        });

        // Rutas de PDF para reportes
        Route::prefix('pdf')->name('pdf.')->group(function () {
            Route::get('/', [PDFController::class, 'index'])->name('index');
            Route::get('/productos/{type}', [PDFController::class, 'productReport'])->name('productos')->where('type', '[1-2]');
            Route::get('/factura/{type}/{orderId}', [PDFController::class, 'orderInvoice'])->name('factura')->where(['type' => '[1-2]', 'orderId' => '[0-9]+']);
        });

        // Rutas específicas para usuarios (AJAX)
        Route::get('/usuarios/entidades/{id_pais}', [UserController::class, 'getEntitiesByCountry'])->name('usuarios.entidades');
        Route::get('/usuarios/municipios/{id_entidad}', [UserController::class, 'getMunicipalitiesByEntity'])->name('usuarios.municipios');
    });

});

// ==========================================
// FALLBACK ROUTE
// ==========================================

Route::fallback(function () {
    return redirect()->route('home');
});
