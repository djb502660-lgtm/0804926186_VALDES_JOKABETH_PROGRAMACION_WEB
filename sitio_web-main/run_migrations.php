<?php

/**
 * Script para ejecutar migraciones directamente
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

try {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Ejecutando Migraciones</title>";
    echo "<style>body{font-family:Arial,sans-serif;padding:20px;background:#f5f5f5;}";
    echo ".container{background:white;padding:30px;border-radius:10px;max-width:800px;margin:0 auto;}";
    echo ".success{color:green;font-weight:bold;}";
    echo ".error{color:red;font-weight:bold;}";
    echo "pre{background:#f0f0f0;padding:15px;border-radius:5px;overflow-x:auto;}</style></head><body>";
    echo "<div class='container'><h1>Ejecutando Migraciones...</h1>";

    // Verificar conexión
    echo "<h3>Verificando conexión a BD...</h3>";
    try {
        DB::connection()->getPdo();
        echo "<p class='success'>✓ Conexión exitosa a SQLite</p>";
    } catch (Exception $e) {
        echo "<p class='error'>✗ Error de conexión: " . $e->getMessage() . "</p>";
        throw $e;
    }

    // Ejecutar migraciones
    echo "<h3>Ejecutando migraciones...</h3>";
    echo "<pre>";
    
    $exitCode = Artisan::call('migrate', [
        '--force' => true,
        '--no-interaction' => true,
    ]);
    
    $output = Artisan::output();
    echo htmlspecialchars($output);
    echo "</pre>";

    if ($exitCode === 0) {
        echo "<p class='success'><strong>✓ Migraciones ejecutadas correctamente</strong></p>";
        echo "<h3>Tablas creadas:</h3>";
        echo "<ul>";
        echo "<li>✓ users</li>";
        echo "<li>✓ cache</li>";
        echo "<li>✓ jobs</li>";
        echo "<li>✓ products</li>";
        echo "<li>✓ categories</li>";
        echo "</ul>";
    } else {
        echo "<p class='error'><strong>✗ Error al ejecutar migraciones (código: " . $exitCode . ")</strong></p>";
    }

    echo "<hr><p><a href='http://127.0.0.1:8000/seed_data.php'>Siguiente: Insertar datos</a></p>";
    echo "</div></body></html>";

} catch (Exception $e) {
    echo "<!DOCTYPE html><html><head><meta charset='UTF-8'></head><body>";
    echo "<div class='container' style='background:white;padding:30px;border-radius:10px;max-width:800px;margin:0 auto;'>";
    echo "<h1 style='color:red;'>Error Fatal:</h1>";
    echo "<pre style='background:#f0f0f0;padding:15px;border-radius:5px;'>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "<p><a href='http://127.0.0.1:8000'>Volver</a></p>";
    echo "</div></body></html>";
}
