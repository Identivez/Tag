<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductAjaxController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('Name')->get();
        $providers = Provider::orderBy('Name')->get();
        return view('products.ajax-manage', compact('categories', 'providers'));
    }

    public function buscarProductos($categoryId)
    {
        $products = Product::where('CategoryId', $categoryId)->with('provider')->orderBy('Name')->get();

        $tabla = "<table class='table table-bordered'>";
        $tabla .= "<thead><tr>
                    <th>ID</th><th>Nombre</th><th>Marca</th><th>Precio</th><th>Stock</th>
                    <th>Proveedor</th><th>Acciones</th>
                   </tr></thead><tbody>";

        foreach($products as $product) {
            $tabla .= "<tr>
                        <td>{$product->ProductId}</td>
                        <td>{$product->Name}</td>
                        <td>{$product->Brand}</td>
                        <td>$" . number_format($product->Price, 2) . "</td>
                        <td>{$product->Stock}</td>
                        <td>" . optional($product->provider)->Name . "</td>
                        <td>
                            <button class='btn btn-success btn-sm' onclick='incrementarStock({$product->ProductId},{$categoryId});'>
                                <i class='fa fa-plus'></i> Stock</button>
                            <button class='btn btn-warning btn-sm' onclick='decrementarStock({$product->ProductId},{$categoryId});'>
                                <i class='fa fa-minus'></i> Stock</button>
                        </td>
                      </tr>";
        }

        if ($products->isEmpty()) {
            $tabla .= "<tr><td colspan='7' class='text-center'>No hay productos en esta categoría</td></tr>";
        }

        $tabla .= "</tbody></table>";
        return $tabla;
    }

    public function incrementarStock($productId, $categoryId)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($productId);
            $oldStock = $product->Stock;
            $product->increment('Stock');
            $newStock = $product->Stock;
            DB::commit();

            $msg = "<div class='alert alert-success'>
                        <h5>Stock actualizado</h5>
                        <p><strong>Producto:</strong> {$product->Name}</p>
                        <p><strong>Antes:</strong> {$oldStock}</p>
                        <p><strong>Ahora:</strong> {$newStock}</p>
                    </div>";

            return $msg . $this->buscarProductos($categoryId);
        } catch (\Exception $e) {
            DB::rollBack();
            return "<div class='alert alert-danger'>Error: {$e->getMessage()}</div>";
        }
    }

    public function decrementarStock($productId, $categoryId)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($productId);

            if ($product->Stock <= 0) {
                return "<div class='alert alert-warning'>El stock ya está en 0</div>" . $this->buscarProductos($categoryId);
            }

            $oldStock = $product->Stock;
            $product->decrement('Stock');
            $newStock = $product->Stock;
            DB::commit();

            $msg = "<div class='alert alert-success'>
                        <h5>Stock actualizado</h5>
                        <p><strong>Producto:</strong> {$product->Name}</p>
                        <p><strong>Antes:</strong> {$oldStock}</p>
                        <p><strong>Ahora:</strong> {$newStock}</p>
                    </div>";

            return $msg . $this->buscarProductos($categoryId);
        } catch (\Exception $e) {
            DB::rollBack();
            return "<div class='alert alert-danger'>Error: {$e->getMessage()}</div>";
        }
    }

    public function buscarProductosPorProveedor($providerId)
    {
        $products = Product::where('ProviderId', $providerId)->with('category')->orderBy('Name')->get();

        $tabla = "<table class='table table-bordered'>";
        $tabla .= "<thead><tr>
                    <th>ID</th><th>Nombre</th><th>Marca</th><th>Precio</th><th>Stock</th>
                    <th>Categoría</th><th>Acciones</th>
                   </tr></thead><tbody>";

        foreach($products as $product) {
            $tabla .= "<tr>
                        <td>{$product->ProductId}</td>
                        <td>{$product->Name}</td>
                        <td>{$product->Brand}</td>
                        <td>$" . number_format($product->Price, 2) . "</td>
                        <td>{$product->Stock}</td>
                        <td>" . optional($product->category)->Name . "</td>
                        <td>
                            <button class='btn btn-primary btn-sm' onclick='editarProducto({$product->ProductId});'>
                                <i class='fa fa-edit'></i> Editar</button>
                        </td>
                      </tr>";
        }

        if ($products->isEmpty()) {
            $tabla .= "<tr><td colspan='7' class='text-center'>No hay productos para este proveedor</td></tr>";
        }

        $tabla .= "</tbody></table>";
        return $tabla;
    }

    public function obtenerProducto($productId)
    {
        $product = Product::with(['category', 'provider'])->find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
        }

        return response()->json(['success' => true, 'product' => $product]);
    }

    public function actualizarProducto(Request $request, $productId)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'Name' => 'required|string|max:100',
                'Price' => 'required|numeric|min:0',
                'Stock' => 'required|integer|min:0',
            ]);

            $product = Product::find($productId);

            if (!$product) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado'], 404);
            }

            $oldData = $product->only(['Name', 'Price', 'Stock']);
            $product->update($request->only(['Name', 'Price', 'Stock']));
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Producto actualizado correctamente',
                'oldProduct' => $oldData,
                'newProduct' => $product->only(['Name', 'Price', 'Stock'])
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
