<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use App\Models\Product;
use App\Models\Category;

try {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Estado del Sistema</title>";
    echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f5f5f5;}";
    echo ".container{background:white;padding:30px;border-radius:10px;max-width:800px;margin:0 auto;}";
    echo ".success{color:green;}";
    echo ".error{color:red;}";
    echo "table{width:100%;border-collapse:collapse;margin:20px 0;}";
    echo "th,td{border:1px solid #ddd;padding:10px;text-align:left;}";
    echo "th{background:#f0f0f0;}</style></head><body>";
    echo "<div class='container'><h1>Estado del Sistema</h1>";

    // Verificar tabla users
    $usersCount = User::count();
    echo "<h2>Tabla: users</h2>";
    echo "<p>Registros: <strong>".$usersCount."</strong></p>";
    if ($usersCount > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th><th>Email</th></tr>";
        foreach (User::all() as $user) {
            echo "<tr><td>".$user->id."</td><td>".$user->name."</td><td>".$user->email."</td></tr>";
        }
        echo "</table>";
    }

    // Verificar tabla products
    $productsCount = Product::count();
    echo "<h2>Tabla: products</h2>";
    echo "<p>Registros: <strong>".$productsCount."</strong></p>";
    if ($productsCount > 0) {
        echo "<p class='success'>✓ Tabla products tiene ".$productsCount." registros</p>";
    } else {
        echo "<p class='error'>✗ Tabla products está vacía</p>";
    }

    // Verificar tabla categories
    $categoriesCount = Category::count();
    echo "<h2>Tabla: categories</h2>";
    echo "<p>Registros: <strong>".$categoriesCount."</strong></p>";
    if ($categoriesCount > 0) {
        echo "<p class='success'>✓ Tabla categories tiene ".$categoriesCount." registros</p>";
    } else {
        echo "<p class='error'>✗ Tabla categories está vacía</p>";
    }

    echo "<hr><p><a href='http://127.0.0.1:8000/login'>Volver al Login</a></p>";
    echo "</div></body></html>";

} catch (Exception $e) {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>";
    echo "<div class='container'><h1 style='color:red;'>Error:</h1>";
    echo "<pre>".$e->getMessage()."</pre>";
    echo "</div></body></html>";
}
