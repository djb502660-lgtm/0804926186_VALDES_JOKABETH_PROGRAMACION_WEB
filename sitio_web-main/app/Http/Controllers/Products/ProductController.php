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
        $products = Product::with('category')->paginate(10);
        return view('productos.index', compact('products'));
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
        $categories = Category::all();
        return view('productos.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
            'category_id' => 'required|exists:categories,id',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'nombre.required' => 'El nombre del producto es obligatorio',
            'precio.required' => 'El precio es obligatorio',
            'precio.numeric' => 'El precio debe ser un número válido',
            'stock.required' => 'El stock es obligatorio',
            'estado.required' => 'El estado es obligatorio',
            'category_id.required' => 'Debe seleccionar una categoría',
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
        return view('productos.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('productos.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0.01',
            'stock' => 'required|integer|min:0',
            'estado' => 'required|in:activo,inactivo',
            'category_id' => 'required|exists:categories,id',
            'imagen' => 'nullable|image|max:2048',
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
}
