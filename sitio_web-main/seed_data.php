<?php

/**
 * Script para insertar datos de prueba
 * Ejecutar desde: http://localhost:8000/seed_data.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;

try {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Insertando Datos de Prueba</title>";
    echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f5f5f5;}";
    echo ".container{background:white;padding:30px;border-radius:10px;max-width:800px;margin:0 auto;}";
    echo ".success{color:green;}";
    echo "pre{background:#f0f0f0;padding:10px;border-radius:5px;}</style></head><body>";
    echo "<div class='container'><h1>Insertando Datos de Prueba...</h1>";

    // Crear usuario admin
    $admin = User::firstOrCreate(
        ['email' => 'admin@example.com'],
        [
            'name' => 'Administrador',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]
    );
    echo "<p class='success'>✓ Usuario admin creado: admin@example.com / password123</p>";

    // Crear categorías
    $categories = [
        ['name' => 'Electrónica', 'description' => 'Productos electrónicos y accesorios'],
        ['name' => 'Ropa', 'description' => 'Prendas de vestir para hombre y mujer'],
        ['name' => 'Libros', 'description' => 'Libros de diversos géneros'],
        ['name' => 'Hogar', 'description' => 'Artículos para el hogar'],
    ];

    foreach ($categories as $cat) {
        Category::firstOrCreate(
            ['name' => $cat['name']],
            $cat
        );
    }
    echo "<p class='success'>✓ Categorías creadas</p>";

    // Crear productos
    $products = [
        [
            'name' => 'Laptop Dell XPS 13',
            'price' => 999.99,
            'stock' => 10,
            'status' => 'active',
            'category_id' => 1,
        ],
        [
            'name' => 'Mouse Logitech MX',
            'price' => 79.99,
            'stock' => 25,
            'status' => 'active',
            'category_id' => 1,
        ],
        [
            'name' => 'Teclado Mecánico',
            'price' => 149.99,
            'stock' => 3,
            'status' => 'active',
            'category_id' => 1,
        ],
        [
            'name' => 'Camiseta Básica',
            'price' => 19.99,
            'stock' => 50,
            'status' => 'active',
            'category_id' => 2,
        ],
        [
            'name' => 'Pantalón Jeans',
            'price' => 49.99,
            'stock' => 30,
            'status' => 'active',
            'category_id' => 2,
        ],
        [
            'name' => 'El Quijote',
            'price' => 15.99,
            'stock' => 15,
            'status' => 'active',
            'category_id' => 3,
        ],
        [
            'name' => 'Lámpara LED',
            'price' => 35.99,
            'stock' => 12,
            'status' => 'active',
            'category_id' => 4,
        ],
    ];

    foreach ($products as $prod) {
        Product::firstOrCreate(
            ['name' => $prod['name']],
            $prod
        );
    }
    echo "<p class='success'>✓ 7 Productos creados</p>";

    echo "<hr>";
    echo "<p><strong>Credenciales de acceso:</strong></p>";
    echo "<ul>";
    echo "<li><strong>Email:</strong> admin@example.com</li>";
    echo "<li><strong>Contraseña:</strong> password123</li>";
    echo "</ul>";
    echo "<p><a href='http://127.0.0.1:8000/login'>Ir al Login</a></p>";
    echo "</div></body></html>";

} catch (Exception $e) {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>";
    echo "<div class='container'><h1 style='color:red;'>Error:</h1>";
    echo "<pre>".$e->getMessage()."</pre>";
    echo "</div></body></html>";
}
