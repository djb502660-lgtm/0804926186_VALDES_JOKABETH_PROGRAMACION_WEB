<?php

// Script para popular la base de datos con datos de prueba

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Category;
use App\Models\Product;

echo "\n";
echo "════════════════════════════════════════════════════════════\n";
echo "   CARGANDO DATOS DE PRUEBA AL SISTEMA\n";
echo "════════════════════════════════════════════════════════════\n\n";

// Limpiar datos anteriores
echo "🗑️  Limpiando datos anteriores...\n";
Product::truncate();
Category::truncate();

// Crear categorías
echo "\n📂 Creando categorías...\n";
echo "─────────────────────────────────────────────────────────────\n";

$categories = [
    [
        'nombre' => 'Electrónica',
        'descripcion' => 'Productos electrónicos y dispositivos modernos',
    ],
    [
        'nombre' => 'Computadoras',
        'descripcion' => 'Laptops, desktops y accesorios de computación',
    ],
    [
        'nombre' => 'Accesorios',
        'descripcion' => 'Accesorios para dispositivos electrónicos',
    ],
    [
        'nombre' => 'Periféricos',
        'descripcion' => 'Mouses, teclados, monitores y periféricos',
    ],
    [
        'nombre' => 'Redes y Conectividad',
        'descripcion' => 'Routers, modems, cables y dispositivos de red',
    ],
];

$createdCategories = [];
foreach ($categories as $cat) {
    $created = Category::create($cat);
    $createdCategories[] = $created;
    echo "  ✓ {$created->nombre}\n";
}

// Crear productos
echo "\n📦 Creando productos...\n";
echo "─────────────────────────────────────────────────────────────\n";

$products = [
    // Electrónica (3 productos)
    [
        'nombre' => 'Smartphone Samsung Galaxy S24',
        'precio' => 799.99,
        'stock' => 15,
        'estado' => 'activo',
        'category_id' => $createdCategories[0]->id,
    ],
    [
        'nombre' => 'Tablet iPad Pro 12.9"',
        'precio' => 1199.99,
        'stock' => 8,
        'estado' => 'activo',
        'category_id' => $createdCategories[0]->id,
    ],
    [
        'nombre' => 'Smartwatch Apple Watch Series 9',
        'precio' => 399.99,
        'stock' => 3,
        'estado' => 'activo',
        'category_id' => $createdCategories[0]->id,
    ],
    
    // Computadoras (3 productos)
    [
        'nombre' => 'Laptop Dell XPS 13',
        'precio' => 1299.99,
        'stock' => 5,
        'estado' => 'activo',
        'category_id' => $createdCategories[1]->id,
    ],
    [
        'nombre' => 'MacBook Pro M3 14"',
        'precio' => 1999.99,
        'stock' => 2,
        'estado' => 'activo',
        'category_id' => $createdCategories[1]->id,
    ],
    [
        'nombre' => 'Laptop ASUS VivoBook 15',
        'precio' => 649.99,
        'stock' => 12,
        'estado' => 'activo',
        'category_id' => $createdCategories[1]->id,
    ],
    
    // Accesorios (3 productos)
    [
        'nombre' => 'Funda Protectora para iPhone',
        'precio' => 29.99,
        'stock' => 50,
        'estado' => 'activo',
        'category_id' => $createdCategories[2]->id,
    ],
    [
        'nombre' => 'Protector de Pantalla Vidrio Templado',
        'precio' => 14.99,
        'stock' => 100,
        'estado' => 'activo',
        'category_id' => $createdCategories[2]->id,
    ],
    [
        'nombre' => 'Cable USB-C Carga Rápida',
        'precio' => 19.99,
        'stock' => 45,
        'estado' => 'activo',
        'category_id' => $createdCategories[2]->id,
    ],
    
    // Periféricos (3 productos)
    [
        'nombre' => 'Mouse Logitech MX Master 3S',
        'precio' => 99.99,
        'stock' => 18,
        'estado' => 'activo',
        'category_id' => $createdCategories[3]->id,
    ],
    [
        'nombre' => 'Teclado Mecánico Corsair K95',
        'precio' => 199.99,
        'stock' => 7,
        'estado' => 'activo',
        'category_id' => $createdCategories[3]->id,
    ],
    [
        'nombre' => 'Monitor LG UltraWide 34"',
        'precio' => 699.99,
        'stock' => 3,
        'estado' => 'activo',
        'category_id' => $createdCategories[3]->id,
    ],
    
    // Redes y Conectividad (3 productos)
    [
        'nombre' => 'Router WiFi 6 ASUS AX6000',
        'precio' => 199.99,
        'stock' => 6,
        'estado' => 'activo',
        'category_id' => $createdCategories[4]->id,
    ],
    [
        'nombre' => 'Modem Docsis 3.1 Netgear',
        'precio' => 149.99,
        'stock' => 5,
        'estado' => 'activo',
        'category_id' => $createdCategories[4]->id,
    ],
    [
        'nombre' => 'Cable Ethernet Cat6 30M',
        'precio' => 24.99,
        'stock' => 80,
        'estado' => 'activo',
        'category_id' => $createdCategories[4]->id,
    ],
];

$totalProducts = 0;
foreach ($products as $prod) {
    $created = Product::create($prod);
    
    $stockStatus = '';
    if ($created->stock <= 0) {
        $stockStatus = '🔴 SIN STOCK';
    } elseif ($created->stock <= 5) {
        $stockStatus = '🟡 BAJO STOCK';
    } else {
        $stockStatus = '🟢 DISPONIBLE';
    }
    
    echo "  ✓ {$created->nombre} - Stock: {$created->stock} {$stockStatus}\n";
    $totalProducts++;
}

// Estadísticas finales
echo "\n";
echo "════════════════════════════════════════════════════════════\n";
echo "   ✅ DATOS CARGADOS EXITOSAMENTE\n";
echo "════════════════════════════════════════════════════════════\n";
echo "📊 Resumen:\n";
echo "   • Categorías creadas: " . count($createdCategories) . "\n";
echo "   • Productos creados: " . $totalProducts . "\n";
echo "   • Usuarios existentes: 1 (admin@sistema.com)\n";
echo "\n";

// Análisis de stock
$lowStockCount = Product::where('stock', '<=', 5)->count();
$outOfStockCount = Product::where('stock', '<=', 0)->count();

echo "📈 Análisis de Stock:\n";
echo "   • Productos disponibles: " . Product::where('stock', '>', 5)->count() . " 🟢\n";
echo "   • Productos con bajo stock: " . ($lowStockCount - $outOfStockCount) . " 🟡\n";
echo "   • Productos sin stock: " . $outOfStockCount . " 🔴\n";
echo "\n";

echo "🌐 Acceso al Sistema:\n";
echo "   URL: http://127.0.0.1:8000\n";
echo "   Email: admin@sistema.com\n";
echo "   Contraseña: admin123\n";
echo "\n";

echo "════════════════════════════════════════════════════════════\n\n";
