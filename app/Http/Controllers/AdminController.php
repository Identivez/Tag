<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;

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

            // Pedidos recientes (con verificación de relación)
            $recentOrders = collect(); // Colección vacía por defecto
            if (method_exists(Order::class, 'user')) {
                $recentOrders = Order::with('user')
                    ->orderBy('OrderDate', 'desc')
                    ->take(5)
                    ->get();
            }

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
     * Dashboard específico de administrador
     *
     * @return \Illuminate\View\View
     */
    public function adminDashboard()
    {
        // Dashboard específico para administradores con más detalles
        try {
            $stats = [
                'users' => User::count(),
                'products' => Product::count(),
                'orders' => Order::count(),
                'categories' => Category::count()
            ];

            $userCount = User::count();
            $orderCount = Order::count();
            $productCount = Product::count();

            $monthlySales = Order::whereMonth('OrderDate', now()->month)
                ->whereYear('OrderDate', now()->year)
                ->sum('TotalAmount') ?? 0;

            // Pedidos recientes con más información
            $recentOrders = Order::with('user')
                ->orderBy('OrderDate', 'desc')
                ->take(10)
                ->get();

            // Productos con stock bajo
            $lowStockProducts = Product::where('Stock', '<=', 5)->count();

            // Usuarios registrados este mes
            $newUsersThisMonth = User::whereMonth('createdAt', now()->month)
                ->whereYear('createdAt', now()->year)
                ->count();

        } catch (\Exception $e) {
            $stats = ['users' => 0, 'products' => 0, 'orders' => 0, 'categories' => 0];
            $userCount = $orderCount = $productCount = $monthlySales = 0;
            $lowStockProducts = $newUsersThisMonth = 0;
            $recentOrders = collect();
        }

        return view('admin.dashboard', compact(
            'stats',
            'userCount',
            'orderCount',
            'productCount',
            'monthlySales',
            'recentOrders',
            'lowStockProducts',
            'newUsersThisMonth'
        ));
    }

    /**
     * Muestra estadísticas detalladas.
     *
     * @return \Illuminate\View\View
     */
    public function statistics()
    {
        try {
            // Estadísticas de usuarios por fecha
            $userStats = User::selectRaw('DATE(createdAt) as date, COUNT(*) as count')
                ->whereNotNull('createdAt')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->take(30)
                ->get();

            // Estadísticas de pedidos (verificar si existe CreatedAt o usar OrderDate)
            $orderStats = Order::selectRaw('DATE(OrderDate) as date, COUNT(*) as count, SUM(TotalAmount) as revenue')
                ->whereNotNull('OrderDate')
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->take(30)
                ->get();

            // Top productos más vendidos
            $topProducts = Product::leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->selectRaw('products.*, SUM(order_details.Quantity) as total_sold')
                ->groupBy('products.ProductId')
                ->orderBy('total_sold', 'desc')
                ->take(10)
                ->get();

            // Ventas por categoría
            $salesByCategory = Category::leftJoin('products', 'categories.CategoryId', '=', 'products.CategoryId')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->selectRaw('categories.Name, SUM(order_details.Quantity * order_details.UnitPrice) as sales')
                ->groupBy('categories.CategoryId', 'categories.Name')
                ->orderBy('sales', 'desc')
                ->get();

        } catch (\Exception $e) {
            $userStats = collect();
            $orderStats = collect();
            $topProducts = collect();
            $salesByCategory = collect();
        }

        return view('admin.statistics', compact(
            'userStats',
            'orderStats',
            'topProducts',
            'salesByCategory'
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
            // Top productos (con verificación de relación)
            $topProducts = collect();
            if (method_exists(Product::class, 'orderDetails')) {
                $topProducts = Product::withCount('orderDetails')
                    ->orderBy('order_details_count', 'desc')
                    ->take(10)
                    ->get();
            } else {
                // Alternativa sin relación
                $topProducts = Product::take(10)->get();
            }

            // Top categorías
            $topCategories = Category::withCount('products')
                ->orderBy('products_count', 'desc')
                ->take(10)
                ->get();

            // Reporte de inventario
            $inventoryReport = Product::where('Stock', '>', 0)
                ->orderBy('Stock', 'asc')
                ->take(20)
                ->get();

            // Reporte de ventas del mes
            $salesReport = Order::with('user')
                ->whereMonth('OrderDate', now()->month)
                ->whereYear('OrderDate', now()->year)
                ->orderBy('OrderDate', 'desc')
                ->get();

        } catch (\Exception $e) {
            $topProducts = collect();
            $topCategories = collect();
            $inventoryReport = collect();
            $salesReport = collect();
        }

        return view('admin.reports', compact(
            'topProducts',
            'topCategories',
            'inventoryReport',
            'salesReport'
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
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'products':
                    $data = Category::withCount('products')
                        ->get()
                        ->map(function($category) {
                            return [
                                'label' => $category->Name,
                                'value' => $category->products_count
                            ];
                        });
                    break;

                case 'users':
                    $data = User::selectRaw('DATE(createdAt) as date, COUNT(*) as count')
                        ->whereMonth('createdAt', now()->month)
                        ->groupBy('date')
                        ->orderBy('date')
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
}
