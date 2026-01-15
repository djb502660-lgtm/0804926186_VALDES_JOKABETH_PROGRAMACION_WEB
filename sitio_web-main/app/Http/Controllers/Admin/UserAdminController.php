<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;

class UserAdminController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        $totalUsers = User::count();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockProducts = Product::where('stock', '<=', 5)->count();
        
        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalProducts',
            'totalCategories',
            'lowStockProducts'
        ));
    }
}
