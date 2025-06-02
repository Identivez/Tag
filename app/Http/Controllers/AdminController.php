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

            // Pedidos recientes sin relación para evitar errores
            $recentOrders = Order::orderBy('OrderDate', 'desc')
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
            // Estadísticas de usuarios por fecha (simplificado)
            $userStats = User::selectRaw('DATE(createdAt) as date, COUNT(*) as count')
                ->whereNotNull('createdAt')
                ->where('createdAt', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();

            // Estadísticas de pedidos
            $orderStats = Order::selectRaw('DATE(OrderDate) as date, COUNT(*) as count, SUM(TotalAmount) as revenue')
                ->whereNotNull('OrderDate')
                ->where('OrderDate', '>=', now()->subDays(30))
                ->groupBy('date')
                ->orderBy('date', 'desc')
                ->get();

            // Top productos (simplificado sin JOIN complejo)
            $topProducts = Product::orderBy('ProductId', 'desc')
                ->take(10)
                ->get();

            // Ventas por categoría (simplificado)
            $salesByCategory = Category::take(5)->get();

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
            // Top productos (simplificado)
            $topProducts = Product::take(10)->get();

            // Top categorías (simplificado)
            $topCategories = Category::take(10)->get();

            // Reporte de inventario
            $inventoryReport = Product::where('Stock', '>', 0)
                ->orderBy('Stock', 'asc')
                ->take(20)
                ->get();

            // Reporte de ventas del mes (sin relación user)
            $salesReport = Order::whereMonth('OrderDate', now()->month)
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
