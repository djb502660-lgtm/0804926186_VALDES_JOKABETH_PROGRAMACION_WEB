<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')
            ->latest()
            ->paginate(10);
        
        // Contar productos con bajo stock
        $lowStockCount = Product::where('stock', '<=', 5)->count();
        
        return view('productos.index', compact('products', 'lowStockCount'));
    }

    public function export()
    {
        $products = Product::with('category')
            ->orderBy('nombre')
            ->get();

        return response()->streamDownload(function () use ($products) {
            echo "\xEF\xBB\xBF";
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nombre', 'Categoria', 'Precio', 'Stock', 'Estado']);

            foreach ($products as $product) {
                fputcsv($handle, [
                    $product->nombre,
                    $product->category->nombre ?? 'N/A',
                    $product->precio,
                    $product->stock,
                    $product->estado,
                ]);
            }

            fclose($handle);
        }, 'productos.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print()
    {
        $products = Product::with('category')
            ->orderBy('nombre')
            ->get();

        return view('productos.print', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('nombre')->get();
        
        // Validar que existan categorías
        if ($categories->isEmpty()) {
            return redirect()->route('admin.categories.create')
                ->with('warning', 'Debe crear al menos una categoría antes de crear productos');
        }
        
        return view('productos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'precio' => 'required|numeric|min:0.01|max:999999.99',
            'stock' => 'required|integer|min:0|max:999999',
            'estado' => 'required|in:activo,inactivo',
            'category_id' => 'required|exists:categories,id',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número válido',
            'precio.min' => 'El precio debe ser mayor a 0',
            'precio.max' => 'El precio no puede exceder 999,999.99',
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'stock.min' => 'El stock no puede ser negativo',
            'stock.max' => 'El stock no puede exceder 999,999',
            'estado.required' => 'El estado es obligatorio',
            'category_id.required' => 'Debe seleccionar una categoría',
            'imagen.image' => 'El archivo debe ser una imagen válida',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['image_path'] = $request->file('imagen')->store('products', 'public');
        }

        Product::create($validated);
        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente');
    }

    public function show(Product $product)
    {
        $product->load('category');
        
        // Verificar si está en stock bajo
        $isLowStock = $product->stock <= 5;
        $stockStatus = $product->stock <= 0 ? 'sin_stock' : ($isLowStock ? 'bajo_stock' : 'disponible');
        
        return view('productos.show', compact('product', 'isLowStock', 'stockStatus'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('nombre')->get();
        return view('productos.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|min:3|max:255',
            'precio' => 'required|numeric|min:0.01|max:999999.99',
            'stock' => 'required|integer|min:0|max:999999',
            'estado' => 'required|in:activo,inactivo',
            'category_id' => 'required|exists:categories,id',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'nombre.min' => 'El nombre debe tener al menos 3 caracteres',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número válido',
            'precio.min' => 'El precio debe ser mayor a 0',
            'precio.max' => 'El precio no puede exceder 999,999.99',
            'stock.required' => 'El stock es obligatorio',
            'stock.integer' => 'El stock debe ser un número entero',
            'stock.min' => 'El stock no puede ser negativo',
            'stock.max' => 'El stock no puede exceder 999,999',
            'estado.required' => 'El estado es obligatorio',
            'category_id.required' => 'Debe seleccionar una categoría',
            'imagen.image' => 'El archivo debe ser una imagen válida',
            'imagen.max' => 'La imagen no puede ser mayor a 2MB',
        ]);

        if ($request->hasFile('imagen')) {
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('imagen')->store('products', 'public');
        }

        $product->update($validated);
        return redirect()->route('products.show', $product)->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Product $product)
    {
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente');
    }

    /**
     * Obtener alertas de bajo stock
     */
    public function lowStockAlert()
    {
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->orderBy('stock')
            ->get();
        
        return response()->json([
            'count' => $lowStockProducts->count(),
            'products' => $lowStockProducts->map(fn($p) => [
                'id' => $p->id,
                'nombre' => $p->nombre,
                'stock' => $p->stock,
                'estado' => $p->stock <= 0 ? 'Sin Stock' : 'Bajo Stock'
            ])
        ]);
    }
}
