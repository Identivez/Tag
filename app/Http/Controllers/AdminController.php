<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Provider;
use App\Models\Country;
use App\Models\Entity;
use App\Models\Municipality;
use App\Models\Favorite;
use App\Models\CartItem;
use App\Models\Review;
use App\Models\Address;
use App\Models\Payment;
use App\Models\OrderDetail;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Muestra el panel de control principal (dashboard común)
     * Compatible con nuestro sistema sin Breeze
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Estadísticas básicas - proteger con try-catch para evitar errores
        try {
            $userCount = User::count();
            $orderCount = Order::count();
            $productCount = Product::count();
            $categoryCount = Category::count();

            // Calcular ventas mensuales (del mes actual)
            $monthlySales = Order::whereMonth('OrderDate', now()->month)
                ->whereYear('OrderDate', now()->year)
                ->sum('TotalAmount') ?? 0;

            // Pedidos recientes sin relación user para evitar errores
            $recentOrders = Order::orderBy('OrderDate', 'desc')
                ->take(5)
                ->get();

        } catch (\Exception $e) {
            // Si hay error en BD, usar valores por defecto
            $userCount = 0;
            $orderCount = 0;
            $productCount = 0;
            $categoryCount = 0;
            $monthlySales = 0;
            $recentOrders = collect();
        }

        // Retornar vista dashboard principal (no admin.dashboard)
        return view('dashboard', compact(
            'userCount',
            'orderCount',
            'productCount',
            'categoryCount',
            'monthlySales',
            'recentOrders'
        ));
    }

    /**
     * Dashboard específico de administrador con estadísticas completas
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        try {
            // Estadísticas principales
            $userCount = User::count();
            $productCount = Product::count();
            $orderCount = Order::count();
            $categoryCount = Category::count();
            $providerCount = Provider::count();
            $countryCount = Country::count();
            $entityCount = Entity::count();
            $municipalityCount = Municipality::count();
            $favoriteCount = Favorite::count();
            $cartItemCount = CartItem::count();
            $reviewCount = Review::count();
            $addressCount = Address::count();
            $paymentCount = Payment::count();

            // Ventas del mes actual
            $monthlySales = Order::whereMonth('OrderDate', now()->month)
                ->whereYear('OrderDate', now()->year)
                ->sum('TotalAmount') ?? 0;

            // Productos con stock bajo (menos de 10 unidades)
            $lowStockProducts = Product::where('Stock', '<=', 10)->count();

            // Nuevos usuarios este mes
            $newUsersThisMonth = User::whereMonth('createdAt', now()->month)
                ->whereYear('createdAt', now()->year)
                ->count();

            // Pedidos pendientes
            $pendingOrders = Order::where('OrderStatus', 'Pendiente')->count();

            // Pedidos recientes (últimos 10)
            $recentOrders = Order::orderBy('OrderDate', 'desc')
                ->take(10)
                ->get();

            // Productos más vendidos (top 5)
            $topProducts = Product::select('products.*')
                ->selectRaw('COALESCE(SUM(order_details.Quantity), 0) as total_sold')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->groupBy('products.ProductId')
                ->orderBy('total_sold', 'desc')
                ->take(5)
                ->get();

            // Categorías con más productos
            $topCategories = Category::select('categories.*')
                ->selectRaw('COUNT(products.ProductId) as product_count')
                ->leftJoin('products', 'categories.CategoryId', '=', 'products.CategoryId')
                ->groupBy('categories.CategoryId')
                ->orderBy('product_count', 'desc')
                ->take(5)
                ->get();

            // Actividad reciente del sistema
            $recentActivity = [
                'new_users' => User::where('createdAt', '>=', now()->subDays(7))->count(),
                'new_orders' => Order::where('OrderDate', '>=', now()->subDays(7))->count(),
                'new_reviews' => Review::where('ReviewDate', '>=', now()->subDays(7))->count(),
                'new_favorites' => Favorite::where('AddedAt', '>=', now()->subDays(7))->count(),
            ];

            // Resumen de ventas por día (últimos 7 días)
            $weeklyStats = [];
            for ($i = 6; $i >= 0; $i--) {
                $date = now()->subDays($i);
                $weeklyStats[] = [
                    'date' => $date->format('Y-m-d'),
                    'day' => $date->format('l'),
                    'orders' => Order::whereDate('OrderDate', $date)->count(),
                    'sales' => Order::whereDate('OrderDate', $date)->sum('TotalAmount') ?? 0,
                ];
            }

        } catch (\Exception $e) {
            // En caso de error, usar valores por defecto
            $userCount = $productCount = $orderCount = $categoryCount = 0;
            $providerCount = $countryCount = $entityCount = $municipalityCount = 0;
            $favoriteCount = $cartItemCount = $reviewCount = $addressCount = $paymentCount = 0;
            $monthlySales = $lowStockProducts = $newUsersThisMonth = $pendingOrders = 0;
            $recentOrders = collect();
            $topProducts = collect();
            $topCategories = collect();
            $recentActivity = [
                'new_users' => 0,
                'new_orders' => 0,
                'new_reviews' => 0,
                'new_favorites' => 0,
            ];
            $weeklyStats = [];
        }

        return view('admin.dashboard', compact(
            'userCount',
            'productCount',
            'orderCount',
            'categoryCount',
            'providerCount',
            'countryCount',
            'entityCount',
            'municipalityCount',
            'favoriteCount',
            'cartItemCount',
            'reviewCount',
            'addressCount',
            'paymentCount',
            'monthlySales',
            'lowStockProducts',
            'newUsersThisMonth',
            'pendingOrders',
            'recentOrders',
            'topProducts',
            'topCategories',
            'recentActivity',
            'weeklyStats'
        ));
    }

    /**
     * Muestra estadísticas detalladas del sistema.
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        try {
            // Estadísticas de usuarios por fecha (últimos 30 días)
            $userStats = User::selectRaw('DATE(createdAt) as date, COUNT(*) as count')
                ->whereNotNull('createdAt')
                ->where('createdAt', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();

            // Estadísticas de pedidos (últimos 30 días)
            $orderStats = Order::selectRaw('DATE(OrderDate) as date, COUNT(*) as count, SUM(TotalAmount) as revenue')
                ->whereNotNull('OrderDate')
                ->where('OrderDate', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();

            // Top productos más vendidos
            $topProducts = Product::select('products.*')
                ->selectRaw('COALESCE(SUM(order_details.Quantity), 0) as units_sold')
                ->selectRaw('COALESCE(SUM(order_details.Quantity * order_details.UnitPrice), 0) as revenue')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->groupBy('products.ProductId')
                ->orderBy('units_sold', 'desc')
                ->take(10)
                ->get();

            // Ventas por categoría
            $salesByCategory = Category::select('categories.*')
                ->selectRaw('COALESCE(SUM(order_details.Quantity * order_details.UnitPrice), 0) as sales')
                ->selectRaw('COUNT(DISTINCT products.ProductId) as product_count')
                ->leftJoin('products', 'categories.CategoryId', '=', 'products.CategoryId')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->groupBy('categories.CategoryId')
                ->orderBy('sales', 'desc')
                ->get();

            // Estadísticas generales del sistema
            $generalStats = [
                'total_users' => User::count(),
                'active_users' => User::whereHas('orders')->count(),
                'total_products' => Product::count(),
                'products_in_stock' => Product::where('Stock', '>', 0)->count(),
                'total_orders' => Order::count(),
                'completed_orders' => Order::where('OrderStatus', 'Completado')->count(),
                'total_revenue' => Order::where('OrderStatus', 'Completado')->sum('TotalAmount'),
                'average_order_value' => Order::where('OrderStatus', 'Completado')->avg('TotalAmount'),
                'total_categories' => Category::count(),
                'total_providers' => Provider::count(),
                'total_reviews' => Review::count(),
                'average_rating' => Review::avg('Rating'),
            ];

            // Usuarios más activos (por número de pedidos)
            $topUsers = User::select('users.*')
                ->selectRaw('COUNT(orders.OrderId) as order_count')
                ->selectRaw('COALESCE(SUM(orders.TotalAmount), 0) as total_spent')
                ->leftJoin('orders', 'users.UserId', '=', 'orders.UserId')
                ->groupBy('users.UserId')
                ->having('order_count', '>', 0)
                ->orderBy('total_spent', 'desc')
                ->take(10)
                ->get();

            // Distribución de pedidos por estado
            $orderStatusDistribution = Order::select('OrderStatus')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('OrderStatus')
                ->get();

            // Productos con stock bajo
            $lowStockReport = Product::select('products.*', 'categories.Name as category_name')
                ->leftJoin('categories', 'products.CategoryId', '=', 'categories.CategoryId')
                ->where('products.Stock', '<=', 10)
                ->orderBy('products.Stock', 'asc')
                ->get();

        } catch (\Exception $e) {
            // En caso de error, usar colecciones vacías
            $userStats = collect();
            $orderStats = collect();
            $topProducts = collect();
            $salesByCategory = collect();
            $topUsers = collect();
            $orderStatusDistribution = collect();
            $lowStockReport = collect();
            $generalStats = [
                'total_users' => 0, 'active_users' => 0, 'total_products' => 0,
                'products_in_stock' => 0, 'total_orders' => 0, 'completed_orders' => 0,
                'total_revenue' => 0, 'average_order_value' => 0, 'total_categories' => 0,
                'total_providers' => 0, 'total_reviews' => 0, 'average_rating' => 0,
            ];
        }

        return view('admin.statistics', compact(
            'userStats',
            'orderStats',
            'topProducts',
            'salesByCategory',
            'generalStats',
            'topUsers',
            'orderStatusDistribution',
            'lowStockReport'
        ));
    }

    /**
     * Muestra reportes del sistema.
     *
     * @return \Illuminate\View\View
     */
    public function reports()
    {
        try {
            // Reporte de inventario (productos con stock bajo)
            $inventoryReport = Product::select('products.*', 'categories.Name as category_name')
                ->leftJoin('categories', 'products.CategoryId', '=', 'categories.CategoryId')
                ->where('products.Stock', '<=', 10)
                ->orderBy('products.Stock', 'asc')
                ->get();

            // Reporte de ventas del mes actual
            $salesReport = Order::select('orders.*', 'users.firstName', 'users.lastName', 'users.email')
                ->leftJoin('users', 'orders.UserId', '=', 'users.UserId')
                ->whereMonth('OrderDate', now()->month)
                ->whereYear('OrderDate', now()->year)
                ->orderBy('OrderDate', 'desc')
                ->get();

            // Reporte de productos más vendidos
            $productsReport = Product::select('products.*')
                ->selectRaw('COALESCE(SUM(order_details.Quantity), 0) as units_sold')
                ->selectRaw('COALESCE(SUM(order_details.Quantity * order_details.UnitPrice), 0) as revenue')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->leftJoin('orders', 'order_details.OrderId', '=', 'orders.OrderId')
                ->where('orders.OrderStatus', '=', 'Completado')
                ->groupBy('products.ProductId')
                ->orderBy('revenue', 'desc')
                ->take(20)
                ->get();

            // Reporte de clientes activos
            $customersReport = User::select('users.*')
                ->selectRaw('COUNT(orders.OrderId) as orders_count')
                ->selectRaw('COALESCE(SUM(orders.TotalAmount), 0) as total_spent')
                ->selectRaw('COALESCE(AVG(orders.TotalAmount), 0) as average_order')
                ->leftJoin('orders', 'users.UserId', '=', 'orders.UserId')
                ->groupBy('users.UserId')
                ->having('orders_count', '>', 0)
                ->orderBy('total_spent', 'desc')
                ->take(50)
                ->get();

        } catch (\Exception $e) {
            // En caso de error, usar colecciones vacías
            $inventoryReport = collect();
            $salesReport = collect();
            $productsReport = collect();
            $customersReport = collect();
        }

        return view('admin.reports', compact(
            'inventoryReport',
            'salesReport',
            'productsReport',
            'customersReport'
        ));
    }

    /**
     * Método para obtener datos para gráficas (AJAX)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chartData(Request $request)
    {
        $type = $request->get('type', 'sales');

        try {
            switch ($type) {
                case 'sales':
                    $data = Order::selectRaw('DATE(OrderDate) as date, SUM(TotalAmount) as total')
                        ->whereMonth('OrderDate', now()->month)
                        ->whereNotNull('OrderDate')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'products':
                    $data = Category::select('Name', 'CategoryId')
                        ->get()
                        ->map(function($category) {
                            return [
                                'label' => $category->Name,
                                'value' => Product::where('CategoryId', $category->CategoryId)->count()
                            ];
                        });
                    break;

                case 'users':
                    $data = User::selectRaw('DATE(createdAt) as date, COUNT(*) as count')
                        ->whereMonth('createdAt', now()->month)
                        ->whereNotNull('createdAt')
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'orders':
                    $data = Order::selectRaw('OrderStatus, COUNT(*) as count')
                        ->groupBy('OrderStatus')
                        ->get();
                    break;

                case 'inventory':
                    $data = Product::selectRaw('
                        CASE
                            WHEN Stock = 0 THEN "Sin Stock"
                            WHEN Stock <= 5 THEN "Stock Bajo"
                            WHEN Stock <= 20 THEN "Stock Medio"
                            ELSE "Stock Alto"
                        END as stock_level,
                        COUNT(*) as count
                    ')
                    ->groupBy('stock_level')
                    ->get();
                    break;

                default:
                    $data = collect();
            }

            return response()->json([
                'success' => true,
                'data' => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener resumen rápido del sistema (para widgets)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function quickSummary()
    {
        try {
            $summary = [
                'today' => [
                    'new_users' => User::whereDate('createdAt', today())->count(),
                    'new_orders' => Order::whereDate('OrderDate', today())->count(),
                    'sales' => Order::whereDate('OrderDate', today())->sum('TotalAmount'),
                ],
                'week' => [
                    'new_users' => User::where('createdAt', '>=', now()->subWeek())->count(),
                    'new_orders' => Order::where('OrderDate', '>=', now()->subWeek())->count(),
                    'sales' => Order::where('OrderDate', '>=', now()->subWeek())->sum('TotalAmount'),
                ],
                'month' => [
                    'new_users' => User::whereMonth('createdAt', now()->month)->count(),
                    'new_orders' => Order::whereMonth('OrderDate', now()->month)->count(),
                    'sales' => Order::whereMonth('OrderDate', now()->month)->sum('TotalAmount'),
                ],
                'alerts' => [
                    'low_stock' => Product::where('Stock', '<=', 5)->count(),
                    'pending_orders' => Order::where('OrderStatus', 'Pendiente')->count(),
                    'new_reviews' => Review::where('ReviewDate', '>=', now()->subDays(3))->count(),
                ]
            ];

            return response()->json([
                'success' => true,
                'summary' => $summary
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener resumen: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Vista principal de gráficas
     */
    public function graficas()
    {
        return view('admin.graficas.index');
    }

    /**
     * Gráfica de áreas
     */
    public function grafica_areas()
    {
        try {
            $ventasPorDia = Order::selectRaw('DATE(OrderDate) as date, SUM(TotalAmount) as total')
                ->where('OrderDate', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date')
                ->get();

            return view('admin.graficas.areas', compact('ventasPorDia'));
        } catch (\Exception $e) {
            return view('admin.graficas.areas')->with('ventasPorDia', collect());
        }
    }

    /**
     * Gráfica de barras
     */
    public function grafica_barras()
    {
        try {
            $ventasPorCategoria = Category::select('categories.Name', 'categories.CategoryId')
                ->selectRaw('COALESCE(SUM(order_details.Quantity * order_details.UnitPrice), 0) as total_ventas')
                ->leftJoin('products', 'categories.CategoryId', '=', 'products.CategoryId')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->groupBy('categories.CategoryId', 'categories.Name')
                ->orderBy('total_ventas', 'desc')
                ->get();

            return view('admin.graficas.barras', compact('ventasPorCategoria'));
        } catch (\Exception $e) {
            return view('admin.graficas.barras')->with('ventasPorCategoria', collect());
        }
    }

    /**
     * Gráfica de pie/dona
     */
    public function grafica_pie()
    {
        try {
            $estadosPedidos = Order::select('OrderStatus')
                ->selectRaw('COUNT(*) as cantidad')
                ->groupBy('OrderStatus')
                ->get();

            return view('admin.graficas.pie', compact('estadosPedidos'));
        } catch (\Exception $e) {
            return view('admin.graficas.pie')->with('estadosPedidos', collect());
        }
    }

    /**
     * Gráfica 3D
     */
    public function grafica_3d()
    {
        try {
            $productos = Product::with('category')
                ->orderBy('Stock', 'desc')
                ->take(10)
                ->get();

            return view('admin.graficas.3d', compact('productos'));
        } catch (\Exception $e) {
            return view('admin.graficas.3d')->with('productos', collect());
        }
    }
}
