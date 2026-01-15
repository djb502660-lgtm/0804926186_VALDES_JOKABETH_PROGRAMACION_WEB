<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->paginate(10);
        return view('categorias.index', compact('categories'));
    }

    public function export()
    {
        $categories = Category::withCount('products')
            ->orderBy('nombre')
            ->get();

        return response()->streamDownload(function () use ($categories) {
            echo "\xEF\xBB\xBF";
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nombre', 'Descripcion', 'Productos']);

            foreach ($categories as $category) {
                fputcsv($handle, [
                    $category->nombre,
                    $category->descripcion ?? '',
                    $category->products_count,
                ]);
            }

            fclose($handle);
        }, 'categorias.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function print()
    {
        $categories = Category::withCount('products')
            ->orderBy('nombre')
            ->get();

        return view('categorias.print', compact('categories'));
    }

    public function create()
    {
        return view('categorias.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categories',
            'descripcion' => 'nullable|string|max:1000',
            'imagen' => 'nullable|image|max:2048',
        ], [
            'nombre.required' => 'El nombre es obligatorio',
            'nombre.unique' => 'Esta categoría ya existe',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['image_path'] = $request->file('imagen')->store('categories', 'public');
        }

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Categoría creada exitosamente');
    }

    public function show(Category $category)
    {
        $category->loadCount('products');
        $category->load('products');
        return view('categorias.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('categorias.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:categories,nombre,' . $category->id,
            'descripcion' => 'nullable|string|max:1000',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $validated['image_path'] = $request->file('imagen')->store('categories', 'public');
        }

        $category->update($validated);
        return redirect()->route('admin.categories.show', $category)->with('success', 'Categoría actualizada exitosamente');
    }

    public function destroy(Category $category)
    {
        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoría eliminada exitosamente');
    }
}
