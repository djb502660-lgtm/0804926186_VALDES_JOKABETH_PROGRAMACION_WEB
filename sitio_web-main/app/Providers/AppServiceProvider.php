<?php

namespace App\Providers;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\QueryException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            $since = now()->subDay();

            $lowStockProducts = Product::with('category')
                ->where('stock', '<=', 5)
                ->orderBy('stock')
                ->limit(5)
                ->get();

            $newUsers = User::where('created_at', '>=', $since)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            $newProducts = Product::with('category')
                ->where('created_at', '>=', $since)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            $newCategories = Category::where('created_at', '>=', $since)
                ->orderByDesc('created_at')
                ->limit(5)
                ->get();

            $notificationCount = $lowStockProducts->count()
                + $newUsers->count()
                + $newProducts->count()
                + $newCategories->count();

            View::share('notificationCount', $notificationCount);
            View::share('lowStockProducts', $lowStockProducts);
            View::share('newUsers', $newUsers);
            View::share('newProducts', $newProducts);
            View::share('newCategories', $newCategories);
        } catch (QueryException $e) {
            // Si la base de datos no está migrada, compartir valores vacíos
            View::share('notificationCount', 0);
            View::share('lowStockProducts', collect());
            View::share('newUsers', collect());
            View::share('newProducts', collect());
            View::share('newCategories', collect());
        }
    }
}
