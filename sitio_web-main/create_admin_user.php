<?php

/**
 * Script para crear usuario administrador
 * Ejecutar desde navegador: http://localhost/create_admin_user.php
 * O desde línea de comandos: php create_admin_user.php
 */

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    // Buscar o crear usuario administrador
    $user = User::updateOrCreate(
        ['email' => 'admin@sistema.com'],
        [
            'name' => 'Administrador',
            'email' => 'admin@sistema.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]
    );

    echo "✅ Usuario administrador creado exitosamente!\n\n";
    echo "📧 Email: admin@sistema.com\n";
    echo "🔑 Contraseña: admin123\n\n";
    echo "⚠️ IMPORTANTE: Cambia la contraseña después del primer acceso.\n";
    echo "💡 Puedes eliminar este archivo después de usarlo por seguridad.\n";

} catch (Exception $e) {
    echo "❌ Error al crear usuario: " . $e->getMessage() . "\n";
    echo "Asegúrate de que las migraciones estén ejecutadas.\n";
}

