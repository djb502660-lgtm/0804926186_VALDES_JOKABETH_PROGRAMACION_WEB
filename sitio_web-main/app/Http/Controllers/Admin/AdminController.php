<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Umbral para considerar un producto con bajo stock
    private const LOW_STOCK_THRESHOLD = 5;

    public function index()
    {
        // Panel principal del administrador
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockProducts = Product::where('stock', '<=', self::LOW_STOCK_THRESHOLD)->count();
        
        return view('admin.index', compact(
            'totalUsers',
            'totalProducts',
            'totalCategories',
            'lowStockProducts'
        ));
    }

    public function settings()
    {
        // Configuración del sistema
        return view('admin.settings');
    }
    public function search(Request $request)
    {
        $query = trim((string) $request->get('q', ''));
        $products = collect();
        $categories = collect();

        if ($query !== '') {
            $products = Product::with('category')
                ->where('nombre', 'like', '%' . $query . '%')
                ->orderBy('nombre')
                ->limit(20)
                ->get();

            $categories = Category::withCount('products')
                ->where('nombre', 'like', '%' . $query . '%')
                ->orWhere('descripcion', 'like', '%' . $query . '%')
                ->orderBy('nombre')
                ->limit(20)
                ->get();
        }

        return view('search.index', compact('query', 'products', 'categories'));
    }
}
