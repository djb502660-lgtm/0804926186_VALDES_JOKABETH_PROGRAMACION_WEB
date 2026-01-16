<?php

// Script para ver los datos guardados en la base de datos

$dbPath = __DIR__ . '/database/database.sqlite';

if (!file_exists($dbPath)) {
    echo "❌ Base de datos no encontrada en: $dbPath\n";
    exit(1);
}

echo "✅ Base de datos encontrada\n";
echo "📍 Ubicación: " . realpath($dbPath) . "\n";
echo "📊 Tamaño: " . round(filesize($dbPath) / 1024, 2) . " KB\n";
echo "⏰ Última modificación: " . date('Y-m-d H:i:s', filemtime($dbPath)) . "\n";
echo "\n" . str_repeat("=", 60) . "\n\n";

try {
    $db = new PDO('sqlite:' . $dbPath);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Obtener todas las tablas
    $tables = $db->query("SELECT name FROM sqlite_master WHERE type='table' ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);
    
    echo "📋 TABLAS EN LA BASE DE DATOS:\n";
    echo str_repeat("-", 60) . "\n";
    
    foreach ($tables as $table) {
        if ($table === 'sqlite_sequence') continue;
        
        $count = $db->query("SELECT COUNT(*) FROM $table")->fetchColumn();
        echo "\n🔹 Tabla: $table ($count registros)\n";
        echo str_repeat("-", 60) . "\n";
        
        // Mostrar estructura
        $columns = $db->query("PRAGMA table_info($table)")->fetchAll(PDO::FETCH_ASSOC);
        echo "  Columnas: " . implode(", ", array_map(fn($c) => $c['name'], $columns)) . "\n";
        
        // Mostrar datos
        if ($count > 0) {
            echo "\n  📌 Registros:\n";
            $rows = $db->query("SELECT * FROM $table LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($rows as $i => $row) {
                echo "     Registro " . ($i + 1) . ":\n";
                foreach ($row as $col => $val) {
                    $display = strlen((string)$val) > 50 ? substr((string)$val, 0, 50) . "..." : $val;
                    echo "       • $col: $display\n";
                }
            }
            
            if ($count > 5) {
                echo "     ... y " . ($count - 5) . " registros más\n";
            }
        }
        echo "\n";
    }
    
    echo str_repeat("=", 60) . "\n";
    echo "✅ RESUMEN:\n";
    echo str_repeat("-", 60) . "\n";
    
    $totalUsers = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $totalProducts = $db->query("SELECT COUNT(*) FROM products")->fetchColumn();
    $totalCategories = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
    
    echo "👥 Usuarios: $totalUsers\n";
    echo "📦 Productos: $totalProducts\n";
    echo "🏷️  Categorías: $totalCategories\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
