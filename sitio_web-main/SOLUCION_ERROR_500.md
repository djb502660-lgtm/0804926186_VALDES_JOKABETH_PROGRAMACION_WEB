# 🔧 Solución: Error 500 (Internal Server Error)

## 🐛 Problema Identificado

El error 500 puede tener varias causas. Basado en los logs, los problemas más comunes son:

1. **Caché desactualizada** - Laravel está usando versiones antiguas en caché
2. **Vistas no encontradas** - Aunque el código parece correcto, la caché puede estar desactualizada
3. **Problemas de permisos** - En archivos de caché o logs

---

## ✅ Solución Rápida: Limpiar Caché

### Opción 1: Desde el Navegador (RECOMENDADO)

1. Asegúrate de que Laragon esté corriendo
2. Abre tu navegador y ve a:
   ```
   http://127.0.0.1:8000/clear_cache.php
   ```
   o
   ```
   http://localhost/clear_cache.php
   ```
3. El script limpiará:
   - ✅ Caché de configuración
   - ✅ Caché de aplicación
   - ✅ Caché de vistas
   - ✅ Caché de rutas

4. **IMPORTANTE**: Elimina el archivo `clear_cache.php` después de usarlo por seguridad

---

### Opción 2: Desde Terminal (si tienes PHP 8.2+)

Si tu terminal tiene PHP 8.2 o superior:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

---

## 🔍 Verificar que Todo Esté Correcto

Después de limpiar la caché, verifica:

### 1. Verificar Rutas
Prueba acceder a:
- `http://127.0.0.1:8000/login` - Debe mostrar formulario de login
- `http://127.0.0.1:8000/register` - Debe mostrar formulario de registro

### 2. Después de Iniciar Sesión
- `http://127.0.0.1:8000/admin` - Debe mostrar dashboard
- `http://127.0.0.1:8000/productos` - Debe mostrar lista de productos
- `http://127.0.0.1:8000/admin/categorias` - Debe mostrar lista de categorías

### 3. Si Sigue el Error 500
Revisa los logs más recientes:
- Abre: `storage/logs/laravel.log`
- Busca las últimas líneas con "ERROR"
- Comparte el mensaje de error específico

---

## 🛠️ Otros Problemas Posibles

### Problema 1: Permisos de Archivos
Si estás en Linux/Mac, verifica permisos:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Problema 2: Base de Datos No Migrada
Si el error menciona tablas que no existen:
1. Ejecuta: `http://127.0.0.1:8000/run_migrations.php`
2. Verifica que las tablas se crearon

### Problema 3: Archivos de Caché Corruptos
Elimina manualmente:
- `storage/framework/cache/data/*`
- `storage/framework/views/*`
- `bootstrap/cache/*` (excepto .gitignore)

---

## 📋 Checklist de Verificación

- [ ] Caché limpiada (usando clear_cache.php)
- [ ] Migraciones ejecutadas (si hay errores de BD)
- [ ] Permisos correctos en storage/ y bootstrap/cache/
- [ ] Logs revisados para identificar error específico
- [ ] Archivos de caché eliminados manualmente (si es necesario)

---

## 🚨 Si Nada Funciona

1. **Revisa el log completo:**
   - Abre: `storage/logs/laravel.log`
   - Copia el último error completo (últimas 50 líneas)
   - Comparte el mensaje para análisis

2. **Verifica la versión de PHP:**
   - El servidor web necesita PHP 8.2+
   - El CLI puede tener otra versión

3. **Reinicia Laragon:**
   - Detén todos los servicios
   - Inicia nuevamente Laragon
   - Intenta de nuevo

---

**Fecha:** Diciembre 2024  
**Prioridad:** ALTA - Debe resolverse primero

