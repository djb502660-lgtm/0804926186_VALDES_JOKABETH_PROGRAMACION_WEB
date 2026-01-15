<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Products\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// --- Rutas de Autenticación (Públicas) ---
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// --- Rutas Protegidas (Requieren Autenticación) ---
Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // --- Módulo 1: General / Usuarios (Dashboard) ---
    Route::get('/dashboard', function () {
        return redirect()->route('admin.index');
    })->name('dashboard');

    Route::get('/buscar', [AdminController::class, 'search'])->name('search');

    // --- Módulo 2: Productos (Carpeta: Products) ---
    Route::get('/productos/exportar', [ProductController::class, 'export'])->name('products.export');
    Route::get('/productos/imprimir', [ProductController::class, 'print'])->name('products.print');
    Route::resource('productos', ProductController::class)
        ->names('products')
        ->parameters(['productos' => 'product']);

    // --- Módulo 3: Administración (Carpeta: Admin) ---
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/config', [AdminController::class, 'settings'])->name('settings');
        Route::get('/usuarios', [UserAdminController::class, 'index'])->name('users');
        Route::get('/categorias/exportar', [CategoryController::class, 'export'])->name('categories.export');
        Route::get('/categorias/imprimir', [CategoryController::class, 'print'])->name('categories.print');
        Route::resource('categorias', CategoryController::class)
            ->names('categories')
            ->parameters(['categorias' => 'category']);
    });
});
