<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductAjaxController extends Controller
{
    /**
     * Mostrar la vista de gestión de productos
     */
    public function index()
    {
        $categories = Category::orderBy('Name')->get();
        $providers = Provider::orderBy('Name')->get();
        return view('products.ajax-manage', compact('categories', 'providers'));
    }

    /**
     * Buscar productos por categoría
     */
    public function buscarProductos($categoryId)
    {
        $products = Product::where('CategoryId', $categoryId)
                    ->orderBy('Name')
                    ->get();

        $tabla = "<table border='1' class='table table-striped'>";
        $tabla .= "<thead>";
        $tabla .= "<tr>";
        $tabla .= "<th>ID</th>";
        $tabla .= "<th>Nombre</th>";
        $tabla .= "<th>Marca</th>";
        $tabla .= "<th>Precio</th>";
        $tabla .= "<th>Stock</th>";
        $tabla .= "<th>Proveedor</th>";
        $tabla .= "<th>Acciones</th>";
        $tabla .= "</tr>";
        $tabla .= "</thead>";
        $tabla .= "<tbody>";

        foreach($products as $product) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $product->ProductId . "</td>";
            $tabla .= "<td>" . $product->Name . "</td>";
            $tabla .= "<td>" . $product->Brand . "</td>";
            $tabla .= "<td>$" . number_format($product->Price, 2) . "</td>";
            $tabla .= "<td>" . $product->Stock . "</td>";
            $tabla .= "<td>" . optional($product->provider)->Name . "</td>";
            $tabla .= "<td>";
            $tabla .= "<button class='btn btn-success btn-sm' ";
            $tabla .= "onclick='incrementarStock(" . $product->ProductId . "," . $categoryId . ");'>";
            $tabla .= "<i class='fa fa-plus'></i> Stock</button> ";
            $tabla .= "<button class='btn btn-warning btn-sm' ";
            $tabla .= "onclick='decrementarStock(" . $product->ProductId . "," . $categoryId . ");'>";
            $tabla .= "<i class='fa fa-minus'></i> Stock</button>";
            $tabla .= "</td>";
            $tabla .= "</tr>";
        }

        if ($products->isEmpty()) {
            $tabla .= "<tr><td colspan='7' class='text-center'>No hay productos en esta categoría</td></tr>";
        }

        $tabla .= "</tbody>";
        $tabla .= "</table>";

        return $tabla;
    }

    /**
     * Incrementar stock de un producto
     */
    public function incrementarStock($productId, $categoryId)
    {
        try {
            DB::beginTransaction();

            // Obtener el producto antes de la actualización
            $productBefore = Product::find($productId);
            $oldStock = $productBefore->Stock;

            // Incrementar el stock
            Product::where('ProductId', $productId)
                ->increment('Stock', 1);

            // Obtener el producto después de la actualización
            $productAfter = Product::find($productId);
            $newStock = $productAfter->Stock;

            DB::commit();

            // Mostrar resultado de la operación
            $result = "<div class='alert alert-success'>";
            $result .= "<h5>Stock actualizado correctamente</h5>";
            $result .= "<p><strong>Producto:</strong> " . $productAfter->Name . "</p>";
            $result .= "<p><strong>Stock anterior:</strong> " . $oldStock . "</p>";
            $result .= "<p><strong>Stock nuevo:</strong> " . $newStock . "</p>";
            $result .= "</div>";

            // Obtener la tabla actualizada
            $tabla = $this->buscarProductos($categoryId);

            return $result . $tabla;

        } catch (\Exception $e) {
            DB::rollBack();
            return "<div class='alert alert-danger'>Error al actualizar el stock: " . $e->getMessage() . "</div>";
        }
    }

    /**
     * Decrementar stock de un producto
     */
    public function decrementarStock($productId, $categoryId)
    {
        try {
            DB::beginTransaction();

            // Obtener el producto antes de la actualización
            $productBefore = Product::find($productId);
            $oldStock = $productBefore->Stock;

            // Verificar que el stock sea mayor que 0
            if ($oldStock <= 0) {
                return "<div class='alert alert-warning'>No se puede decrementar más el stock. El valor actual es 0.</div>" .
                       $this->buscarProductos($categoryId);
            }

            // Decrementar el stock
            Product::where('ProductId', $productId)
                ->decrement('Stock', 1);

            // Obtener el producto después de la actualización
            $productAfter = Product::find($productId);
            $newStock = $productAfter->Stock;

            DB::commit();

            // Mostrar resultado de la operación
            $result = "<div class='alert alert-success'>";
            $result .= "<h5>Stock actualizado correctamente</h5>";
            $result .= "<p><strong>Producto:</strong> " . $productAfter->Name . "</p>";
            $result .= "<p><strong>Stock anterior:</strong> " . $oldStock . "</p>";
            $result .= "<p><strong>Stock nuevo:</strong> " . $newStock . "</p>";
            $result .= "</div>";

            // Obtener la tabla actualizada
            $tabla = $this->buscarProductos($categoryId);

            return $result . $tabla;

        } catch (\Exception $e) {
            DB::rollBack();
            return "<div class='alert alert-danger'>Error al actualizar el stock: " . $e->getMessage() . "</div>";
        }
    }

    /**
     * Buscar productos por proveedor
     */
    public function buscarProductosPorProveedor($providerId)
    {
        $products = Product::where('ProviderId', $providerId)
                    ->orderBy('Name')
                    ->get();

        $tabla = "<table border='1' class='table table-striped'>";
        $tabla .= "<thead>";
        $tabla .= "<tr>";
        $tabla .= "<th>ID</th>";
        $tabla .= "<th>Nombre</th>";
        $tabla .= "<th>Marca</th>";
        $tabla .= "<th>Precio</th>";
        $tabla .= "<th>Stock</th>";
        $tabla .= "<th>Categoría</th>";
        $tabla .= "<th>Acciones</th>";
        $tabla .= "</tr>";
        $tabla .= "</thead>";
        $tabla .= "<tbody>";

        foreach($products as $product) {
            $tabla .= "<tr>";
            $tabla .= "<td>" . $product->ProductId . "</td>";
            $tabla .= "<td>" . $product->Name . "</td>";
            $tabla .= "<td>" . $product->Brand . "</td>";
            $tabla .= "<td>$" . number_format($product->Price, 2) . "</td>";
            $tabla .= "<td>" . $product->Stock . "</td>";
            $tabla .= "<td>" . optional($product->category)->Name . "</td>";
            $tabla .= "<td>";
            $tabla .= "<button class='btn btn-primary btn-sm' ";
            $tabla .= "onclick='editarProducto(" . $product->ProductId . ");'>";
            $tabla .= "<i class='fa fa-edit'></i> Editar</button>";
            $tabla .= "</td>";
            $tabla .= "</tr>";
        }

        if ($products->isEmpty()) {
            $tabla .= "<tr><td colspan='7' class='text-center'>No hay productos para este proveedor</td></tr>";
        }

        $tabla .= "</tbody>";
        $tabla .= "</table>";

        return $tabla;
    }

    /**
     * Obtener detalles de un producto para edición
     */
    public function obtenerProducto($productId)
    {
        $product = Product::with(['category', 'provider'])->find($productId);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    /**
     * Actualizar información de un producto
     */
    public function actualizarProducto(Request $request, $productId)
    {
        try {
            DB::beginTransaction();

            // Validar datos
            $request->validate([
                'Name' => 'required|string|max:100',
                'Price' => 'required|numeric|min:0',
                'Stock' => 'required|integer|min:0',
            ]);

            // Buscar el producto
            $product = Product::find($productId);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Producto no encontrado'
                ], 404);
            }

            // Guardar datos anteriores
            $oldProduct = [
                'Name' => $product->Name,
                'Price' => $product->Price,
                'Stock' => $product->Stock
            ];

            // Actualizar el producto
            $product->Name = $request->Name;
            $product->Price = $request->Price;
            $product->Stock = $request->Stock;
            $product->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'oldProduct' => $oldProduct,
                'newProduct' => [
                    'Name' => $product->Name,
                    'Price' => $product->Price,
                    'Stock' => $product->Stock
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el producto: ' . $e->getMessage()
            ], 500);
        }
    }
}
