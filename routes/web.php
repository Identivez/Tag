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
use App\Http\Controllers\AdminStatsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GraficasController;

// ==========================================
// RUTAS PÚBLICAS
// ==========================================

// Página de inicio
Route::get('/', [ShopController::class, 'index'])->name('home');

// Rutas públicas de la tienda
Route::prefix('shop')->name('shop.')->group(function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/product/{product}', [ShopController::class, 'show'])->name('product');
    Route::get('/category/{category}', [ShopController::class, 'byCategory'])->name('category');
    Route::get('/search', [ShopController::class, 'search'])->name('search');
});

// Rutas de contacto y email (PÚBLICAS)
Route::get('/contact', [EmailController::class, 'showContactForm'])->name('contact');

Route::post('/contact', [EmailController::class, 'sendContactEmail'])->name('contact.send');

// Newsletter
Route::post('/newsletter/subscribe', function() {
    return redirect()->back()->with('success', 'Te has suscrito exitosamente al newsletter.');
})->name('newsletter.subscribe');

// Rutas AJAX públicas (países->entidades->municipios)
Route::prefix('ajax')->group(function () {
    Route::get('/entities/{id_pais}', [AjaxController::class, 'cambia_combo']);
    Route::get('/municipalities/{id_entidad}', [AjaxController::class, 'cambia_combo_2']);
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
    // RUTAS DE USUARIO NORMAL (DISPONIBLES PARA TODOS LOS USUARIOS AUTENTICADOS)
    // ==========================================

    // Carrito de compras
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartItemController::class, 'viewCart'])->name('view');
        Route::post('/add', [CartItemController::class, 'addToCart'])->name('add');
        Route::patch('/update/{cartId}', [CartItemController::class, 'updateQuantity'])->name('update');
        Route::delete('/remove/{cartId}', [CartItemController::class, 'removeFromCart'])->name('remove');
        Route::delete('/clear', [CartItemController::class, 'clearCart'])->name('clear');
    });

    // Favoritos (disponibles para todos los usuarios autenticados)
    Route::prefix('favorites')->name('favorites.')->group(function () {
        Route::get('/', [FavoriteController::class, 'userFavorites'])->name('user');
        Route::post('/toggle', [FavoriteController::class, 'toggleFavorite'])->name('toggle');
        Route::get('/check/{productId}', [FavoriteController::class, 'checkFavorite'])->name('check');
        Route::delete('/bulk-remove', [FavoriteController::class, 'bulkRemove'])->name('bulk-remove');
    });

    // Pedidos de usuario
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('/place', [OrderController::class, 'placeOrder'])->name('place');
        Route::get('/confirmation/{orderId}', [OrderController::class, 'confirmation'])->name('confirmation');
        Route::patch('/cancel/{orderId}', [OrderController::class, 'cancelOrder'])->name('cancel');
    });

    // Reseñas
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // ==========================================
    // RUTAS PARA TODOS LOS USUARIOS AUTENTICADOS (admin/manager)
    // ==========================================

   Route::middleware(['auth', 'role:admin|manager'])->group(function () {
    Route::resource('countries', CountryController::class);
    Route::resource('entities', EntityController::class);
    Route::resource('municipalities', MunicipalityController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('providers', ProviderController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('images', ImageController::class);
    Route::resource('product-inventories', ProductInventoryController::class);
    Route::resource('provider-details', ProviderDetailController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('order-details', OrderDetailController::class);
    Route::resource('payments', PaymentController::class);
    Route::resource('addresses', AddressController::class);
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);

Route::get('/ubicacion', function () {
    $paises = \App\Models\Country::orderBy('Name')->get();
    return view('ubicacion', compact('paises'));
});

    //graficas
    Route::get('graficas', [GraficasController::class, 'index'])->name('graficas.index');
    Route::get('graficas/barras', [GraficasController::class, 'barras'])->name('graficas.barras');
    Route::get('graficas/pie', [GraficasController::class, 'pie'])->name('graficas.pie');
    Route::get('graficas/columnas', [GraficasController::class, 'columnas'])->name('graficas.columnas');
});

    // ==========================================
    // RUTAS PARA ADMIN ESPECÍFICAS
    // ==========================================

    // Dashboard de administrador específico
    Route::get('/admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');

    // Estadísticas y reportes
    Route::get('/admin/statistics', [AdminStatsController::class, 'statistics'])->name('admin.statistics');
    Route::get('/admin/reports', [AdminStatsController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/export-report', [AdminStatsController::class, 'exportReport'])->name('admin.export.report');

    // Rutas admin para favoritos y cart-items
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('favorites', FavoriteController::class);
        Route::resource('cart-items', CartItemController::class);

        // ==========================================
        // SISTEMA DE CORREOS ELECTRÓNICOS - ADMIN
        // ==========================================

        Route::prefix('emails')->name('emails.')->group(function () {
            // Panel principal de envío de correos
            Route::get('/', [EmailController::class, 'showAdminEmailForm'])->name('form');
            Route::post('/send', [EmailController::class, 'sendAdminEmail'])->name('send');

            // Correos específicos del sistema
            Route::post('/order-confirmation/{orderId}', [EmailController::class, 'sendOrderConfirmation'])->name('order.confirmation');
            Route::post('/welcome/{userId}', [EmailController::class, 'sendWelcomeEmail'])->name('welcome');

            // Sistema de pruebas
            Route::get('/test', [EmailController::class, 'testEmail'])->name('test');

            // Historial y estadísticas (futuro)
            Route::get('/history', function() {
                return view('admin.emails.history');
            })->name('history');
        });
    });

    // ==========================================
    // RUTAS AJAX
    // ==========================================

   Route::prefix('ajax')->name('ajax.')->group(function () {
    // Selects dependientes
    Route::get('/entities/{id_pais}', [AjaxController::class, 'cambia_combo']);
    Route::get('/municipalities/{id_entidad}', [AjaxController::class, 'cambia_combo_2']);
    Route::get('/buscar-municipios', [AjaxController::class, 'buscarMunicipios'])->name('buscar.municipios');
    Route::get('/entity/{id}', [AjaxController::class, 'getEntidadDetalles'])->name('entity.detalles');
    Route::get('/municipality/{id}', [AjaxController::class, 'getMunicipioDetalles'])->name('municipality.detalles');

    // Gestión productos AJAX
    Route::get('/products', [ProductAjaxController::class, 'index'])->name('products.index');
    Route::get('/products/category/{categoryId}', [ProductAjaxController::class, 'buscarProductos'])->name('products.category');
    Route::get('/products/provider/{providerId}', [ProductAjaxController::class, 'buscarProductosPorProveedor'])->name('products.provider');
    // Estas deben estar dentro del grupo '/ajax'
Route::post('/products/{productId}/increment-stock/{categoryId}', [ProductAjaxController::class, 'incrementarStock'])->name('products.increment');
Route::post('/products/{productId}/decrement-stock/{categoryId}', [ProductAjaxController::class, 'decrementarStock'])->name('products.decrement');


    Route::get('/products/{productId}/get', [ProductAjaxController::class, 'obtenerProducto'])->name('products.get');
    Route::put('/products/{productId}/update', [ProductAjaxController::class, 'actualizarProducto'])->name('products.update');

    // Opcionales dinámicos de ubicación
    Route::get('/locations', [LocationController::class, 'index'])->name('locations.index');
    Route::get('/locations/entities/{countryId}', [LocationController::class, 'getEntities'])->name('locations.entities');
    Route::get('/locations/municipalities/{entityId}', [LocationController::class, 'getMunicipalities'])->name('locations.municipalities');
    Route::get('/locations/municipality/{municipalityId}', [LocationController::class, 'getMunicipalityDetails'])->name('locations.municipality.details');
    Route::put('/locations/municipality/{municipalityId}/status', [LocationController::class, 'updateMunicipalityStatus'])->name('locations.municipality.status');
    Route::get('/locations/dynamic-data', [LocationController::class, 'dynamicData'])->name('locations.dynamic');
    Route::get('/locations/entity/{entityId}', [LocationController::class, 'getEntityDetails'])->name('locations.entity.details');
    Route::put('/locations/entity/{entityId}/name', [LocationController::class, 'updateEntityName'])->name('locations.entity.name');
});


    // ==========================================
    // RUTAS DE EMAIL GENERAL (PARA USUARIOS AUTENTICADOS)
    // ==========================================

    Route::prefix('email')->name('email.')->group(function () {
        // Confirmación de pedidos (disponible para usuarios que hicieron el pedido)
        Route::post('/order-confirmation/{orderId}', [EmailController::class, 'sendOrderConfirmation'])->name('order.confirmation');

        // Otras funcionalidades de email para usuarios
        Route::get('/preferences', function() {
            return view('emails.preferences');
        })->name('preferences');
    });

    // ==========================================
    // RUTAS DE PDF PARA REPORTES
    // ==========================================

   Route::get('/pdf', [PdfController::class, 'index'])->name('pdf.index');
Route::get('/pdf/productos/{tipo}', [PdfController::class, 'reporteProductos'])->name('pdf.productos');
Route::get('/pdf/stock-bajo/{tipo}', [PdfController::class, 'reporteStockBajo'])->name('pdf.stock_bajo');
Route::get('/pdf/usuarios-pedidos/{tipo}', [PdfController::class, 'reporteUsuariosPedidos'])->name('pdf.usuarios_pedidos');
Route::get('/pdf/productos-por-categoria/{tipo}', [PdfController::class, 'reporteProductosPorCategoria'])->name('pdf.productos_categoria');


    // ==========================================
    // RUTAS ESPECÍFICAS ADICIONALES
    // ==========================================

    // Rutas específicas para usuarios (AJAX)
    Route::get('/users/entities/{id_pais}', [UserController::class, 'getEntitiesByCountry'])->name('users.entities');
    Route::get('/users/municipalities/{id_entidad}', [UserController::class, 'getMunicipalitiesByEntity'])->name('users.municipalities');

});



// ==========================================
// FALLBACK ROUTE
// ==========================================

Route::fallback(function () {
    return redirect()->route('home');
});
