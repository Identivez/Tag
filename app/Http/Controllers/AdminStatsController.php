<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\OrderDetail;
use App\Models\Provider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminStatsController extends Controller
{
    /**
     * Muestra las estadísticas del panel administrativo.
     */
    public function statistics(Request $request)
    {
        try {
            $period = $request->get('period', 'month');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            // Configurar fechas según el período
            $dateRange = $this->getDateRange($period, $startDate, $endDate);

            // Estadísticas básicas
            $totalSales = Order::whereBetween('OrderDate', [$dateRange['start'], $dateRange['end']])
                ->sum('TotalAmount');

            $orderCount = Order::whereBetween('OrderDate', [$dateRange['start'], $dateRange['end']])
                ->count();

            $averageOrderValue = $orderCount > 0 ? $totalSales / $orderCount : 0;

            $newUsersCount = User::whereBetween('createdAt', [$dateRange['start'], $dateRange['end']])
                ->count();

            // Productos más vendidos
            $topProducts = Product::select('products.*')
                ->selectRaw('SUM(order_details.Quantity) as quantity_sold')
                ->selectRaw('SUM(order_details.Quantity * order_details.UnitPrice) as revenue')
                ->join('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->join('orders', 'order_details.OrderId', '=', 'orders.OrderId')
                ->whereBetween('orders.OrderDate', [$dateRange['start'], $dateRange['end']])
                ->groupBy('products.ProductId')
                ->orderBy('quantity_sold', 'desc')
                ->take(10)
                ->get();

            // Ventas por categoría
            $salesByCategory = Category::select('categories.*')
                ->selectRaw('COALESCE(SUM(order_details.Quantity * order_details.UnitPrice), 0) as sales')
                ->leftJoin('products', 'categories.CategoryId', '=', 'products.CategoryId')
                ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                ->leftJoin('orders', 'order_details.OrderId', '=', 'orders.OrderId')
                ->when($dateRange['start'] && $dateRange['end'], function ($query) use ($dateRange) {
                    return $query->whereBetween('orders.OrderDate', [$dateRange['start'], $dateRange['end']]);
                })
                ->groupBy('categories.CategoryId')
                ->orderBy('sales', 'desc')
                ->get();

            // Calcular porcentajes para las categorías
            $totalCategorySales = $salesByCategory->sum('sales');
            $salesByCategory = $salesByCategory->map(function ($category) use ($totalCategorySales) {
                $category->percentage = $totalCategorySales > 0 ? ($category->sales / $totalCategorySales) * 100 : 0;
                return $category;
            });

            // Usuarios más activos
            $topUsers = User::select('users.*')
                ->selectRaw('COUNT(orders.OrderId) as order_count')
                ->selectRaw('COALESCE(SUM(orders.TotalAmount), 0) as total_spent')
                ->leftJoin('orders', 'users.UserId', '=', 'orders.UserId')
                ->when($dateRange['start'] && $dateRange['end'], function ($query) use ($dateRange) {
                    return $query->whereBetween('orders.OrderDate', [$dateRange['start'], $dateRange['end']]);
                })
                ->groupBy('users.UserId')
                ->having('order_count', '>', 0)
                ->orderBy('total_spent', 'desc')
                ->take(10)
                ->get();

            // Estadísticas adicionales
            $lowStockProducts = Product::where('Stock', '<=', 10)->count();
            $totalProducts = Product::count();
            $totalCategories = Category::count();
            $totalProviders = Provider::count();

            return view('admin.statistics', compact(
                'totalSales',
                'orderCount',
                'averageOrderValue',
                'newUsersCount',
                'topProducts',
                'salesByCategory',
                'topUsers',
                'lowStockProducts',
                'totalProducts',
                'totalCategories',
                'totalProviders',
                'period',
                'startDate',
                'endDate'
            ));

        } catch (\Exception $e) {
            Log::error('Error en estadísticas: ' . $e->getMessage());

            return view('admin.statistics')->with('error', 'Error al cargar las estadísticas.');
        }
    }

    /**
     * Muestra los reportes del panel administrativo.
     */
    public function reports(Request $request)
    {
        try {
            $reportType = $request->get('report_type');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            $data = [
                'salesReport' => null,
                'inventoryReport' => null,
                'customersReport' => null,
                'productsReport' => null
            ];

            if ($reportType && $startDate && $endDate) {
                $reportData = $this->generateReport($reportType, $startDate, $endDate);
                $data = array_merge($data, $reportData);
            }

            return view('admin.reports', $data);

        } catch (\Exception $e) {
            Log::error('Error en reportes: ' . $e->getMessage());

            return view('admin.reports')->with('error', 'Error al generar el reporte.');
        }
    }

    /**
     * Genera reportes específicos según el tipo solicitado.
     */
    private function generateReport($type, $startDate, $endDate)
    {
        switch ($type) {
            case 'sales':
                return [
                    'salesReport' => Order::with(['user', 'orderDetails'])
                        ->whereBetween('OrderDate', [$startDate, $endDate])
                        ->orderBy('OrderDate', 'desc')
                        ->get()
                ];

            case 'inventory':
                return [
                    'inventoryReport' => Product::with('category')
                        ->orderBy('Stock', 'asc')
                        ->get()
                ];

            case 'customers':
                return [
                    'customersReport' => User::select('users.*')
                        ->selectRaw('COUNT(orders.OrderId) as orders_count')
                        ->selectRaw('COALESCE(SUM(orders.TotalAmount), 0) as total_spent')
                        ->selectRaw('COALESCE(AVG(orders.TotalAmount), 0) as average_order')
                        ->leftJoin('orders', 'users.UserId', '=', 'orders.UserId')
                        ->whereBetween('users.createdAt', [$startDate, $endDate])
                        ->groupBy('users.UserId')
                        ->orderBy('total_spent', 'desc')
                        ->get()
                ];

            case 'products':
                return [
                    'productsReport' => Product::select('products.*')
                        ->selectRaw('COALESCE(SUM(order_details.Quantity), 0) as units_sold')
                        ->selectRaw('COALESCE(SUM(order_details.Quantity * order_details.UnitPrice), 0) as revenue')
                        ->selectRaw('0 as performance') // Simplified performance calculation
                        ->with('category')
                        ->leftJoin('order_details', 'products.ProductId', '=', 'order_details.ProductId')
                        ->leftJoin('orders', 'order_details.OrderId', '=', 'orders.OrderId')
                        ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                            return $query->whereBetween('orders.OrderDate', [$startDate, $endDate]);
                        })
                        ->groupBy('products.ProductId')
                        ->orderBy('revenue', 'desc')
                        ->get()
                ];

            default:
                return [];
        }
    }

    /**
     * Obtiene el rango de fechas según el período especificado.
     */
    private function getDateRange($period, $startDate = null, $endDate = null)
    {
        if ($period === 'custom' && $startDate && $endDate) {
            return [
                'start' => Carbon::parse($startDate)->startOfDay(),
                'end' => Carbon::parse($endDate)->endOfDay()
            ];
        }

        switch ($period) {
            case 'month':
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth()
                ];

            case 'quarter':
                return [
                    'start' => Carbon::now()->startOfQuarter(),
                    'end' => Carbon::now()->endOfQuarter()
                ];

            case 'year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now()->endOfYear()
                ];

            default:
                return [
                    'start' => Carbon::now()->startOfMonth(),
                    'end' => Carbon::now()->endOfMonth()
                ];
        }
    }

    /**
     * Exporta reportes en formato CSV.
     */
    public function exportReport(Request $request)
    {
        try {
            $reportType = $request->get('report_type');
            $startDate = $request->get('start_date');
            $endDate = $request->get('end_date');

            if (!$reportType || !$startDate || !$endDate) {
                return redirect()->back()->with('error', 'Faltan parámetros para exportar el reporte.');
            }

            $data = $this->generateReport($reportType, $startDate, $endDate);

            // Configurar headers para descarga de CSV
            $filename = "{$reportType}_report_" . date('Y-m-d') . '.csv';

            return response()->streamDownload(function () use ($data, $reportType) {
                $output = fopen('php://output', 'w');

                // Escribir BOM para UTF-8
                fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

                // Escribir encabezados según el tipo de reporte
                $this->writeCSVHeaders($output, $reportType);

                // Escribir datos
                $this->writeCSVData($output, $data, $reportType);

                fclose($output);
            }, $filename, [
                'Content-Type' => 'text/csv; charset=UTF-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ]);

        } catch (\Exception $e) {
            Log::error('Error al exportar reporte: ' . $e->getMessage());

            return redirect()->back()->with('error', 'Error al exportar el reporte.');
        }
    }

    /**
     * Escribe los encabezados del CSV según el tipo de reporte.
     */
    private function writeCSVHeaders($output, $reportType)
    {
        switch ($reportType) {
            case 'sales':
                fputcsv($output, ['Fecha', 'Pedido', 'Cliente', 'Email', 'Total', 'Estado']);
                break;
            case 'inventory':
                fputcsv($output, ['ID', 'Producto', 'Categoría', 'Stock', 'Precio', 'Estado']);
                break;
            case 'customers':
                fputcsv($output, ['Cliente', 'Email', 'Registro', 'Pedidos', 'Gasto Total', 'Promedio']);
                break;
            case 'products':
                fputcsv($output, ['Producto', 'Categoría', 'Precio', 'Unidades Vendidas', 'Ingresos', 'Rendimiento']);
                break;
        }
    }

    /**
     * Escribe los datos del CSV según el tipo de reporte.
     */
    private function writeCSVData($output, $data, $reportType)
    {
        switch ($reportType) {
            case 'sales':
                if (!empty($data['salesReport'])) {
                    foreach ($data['salesReport'] as $order) {
                        fputcsv($output, [
                            $order->OrderDate ? Carbon::parse($order->OrderDate)->format('d/m/Y H:i') : 'N/A',
                            $order->OrderId,
                            ($order->user->firstName ?? '') . ' ' . ($order->user->lastName ?? ''),
                            $order->user->email ?? 'N/A',
                            number_format($order->TotalAmount, 2),
                            $order->OrderStatus ?? 'N/A'
                        ]);
                    }
                }
                break;

            case 'inventory':
                if (!empty($data['inventoryReport'])) {
                    foreach ($data['inventoryReport'] as $product) {
                        fputcsv($output, [
                            $product->ProductId,
                            $product->Name,
                            $product->category->Name ?? 'Sin categoría',
                            $product->Stock ?? 0,
                            number_format($product->Price, 2),
                            $product->Stock > 10 ? 'En stock' : ($product->Stock > 0 ? 'Stock bajo' : 'Agotado')
                        ]);
                    }
                }
                break;

            case 'customers':
                if (!empty($data['customersReport'])) {
                    foreach ($data['customersReport'] as $customer) {
                        fputcsv($output, [
                            ($customer->firstName ?? '') . ' ' . ($customer->lastName ?? ''),
                            $customer->email,
                            $customer->createdAt ? Carbon::parse($customer->createdAt)->format('d/m/Y') : 'N/A',
                            $customer->orders_count ?? 0,
                            number_format($customer->total_spent ?? 0, 2),
                            number_format($customer->average_order ?? 0, 2)
                        ]);
                    }
                }
                break;

            case 'products':
                if (!empty($data['productsReport'])) {
                    foreach ($data['productsReport'] as $product) {
                        fputcsv($output, [
                            $product->Name,
                            $product->category->Name ?? 'Sin categoría',
                            number_format($product->Price, 2),
                            $product->units_sold ?? 0,
                            number_format($product->revenue ?? 0, 2),
                            number_format($product->performance ?? 0, 1) . '%'
                        ]);
                    }
                }
                break;
        }
    }

    /**
     * API endpoint para obtener datos de gráficos (AJAX).
     */
    public function getChartData(Request $request)
    {
        try {
            $type = $request->get('type', 'sales');
            $period = $request->get('period', 'month');

            $dateRange = $this->getDateRange($period);

            switch ($type) {
                case 'sales':
                    $data = Order::selectRaw('DATE(OrderDate) as date, SUM(TotalAmount) as total')
                        ->whereBetween('OrderDate', [$dateRange['start'], $dateRange['end']])
                        ->groupBy('date')
                        ->orderBy('date')
                        ->get();
                    break;

                case 'orders':
                    $data = Order::selectRaw('DATE(OrderDate) as date, COUNT(*) as count')
                        ->whereBetween('OrderDate', [$dateRange['start'], $dateRange['end']])
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
            Log::error('Error en getChartData: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener datos del gráfico'
            ], 500);
        }
    }

    /**
     * Obtiene el resumen rápido para el dashboard.
     */
    public function quickStats()
    {
        try {
            $today = Carbon::today();
            $thisMonth = Carbon::now()->startOfMonth();

            $stats = [
                'today_sales' => Order::whereDate('OrderDate', $today)->sum('TotalAmount'),
                'today_orders' => Order::whereDate('OrderDate', $today)->count(),
                'month_sales' => Order::where('OrderDate', '>=', $thisMonth)->sum('TotalAmount'),
                'month_orders' => Order::where('OrderDate', '>=', $thisMonth)->count(),
                'pending_orders' => Order::where('OrderStatus', 'Pendiente')->count(),
                'low_stock_products' => Product::where('Stock', '<=', 10)->count(),
                'total_customers' => User::whereHas('roles', function($q) {
                    $q->where('RoleId', 'customer');
                })->count(),
                'new_customers_month' => User::where('createdAt', '>=', $thisMonth)
                    ->whereHas('roles', function($q) {
                        $q->where('RoleId', 'customer');
                    })->count(),
            ];

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error en quickStats: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas rápidas'
            ], 500);
        }
    }
}
