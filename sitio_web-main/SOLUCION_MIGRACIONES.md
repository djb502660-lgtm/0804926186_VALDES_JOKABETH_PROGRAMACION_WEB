# 🔧 Solución: Error "no such table: products"

## Problema
El error indica que las tablas de la base de datos no existen. Necesitas ejecutar las migraciones.

---

## ✅ Solución Rápida

### Opción 1: Desde el Navegador (RECOMENDADO)

1. Asegúrate de que Laragon esté corriendo
2. Abre tu navegador y ve a:
   ```
   http://127.0.0.1:8000/run_migrations.php
   ```
   o
   ```
   http://localhost/run_migrations.php
   ```
3. Deberías ver un mensaje de éxito
4. **IMPORTANTE**: Elimina el archivo `run_migrations.php` después de usarlo por seguridad

---

### Opción 2: Desde Laragon Terminal

1. Abre Laragon
2. Haz clic derecho en el proyecto
3. Selecciona "Terminal aquí" o "Open terminal here"
4. Ejecuta:
   ```bash
   php artisan migrate
   ```

---

### Opción 3: Cambiar Versión de PHP en Terminal

Si tu terminal usa PHP 8.0 pero Laragon tiene PHP 8.2+:

1. En Laragon, ve a: Menu → PHP → Versions
2. Selecciona PHP 8.2 o superior
3. Luego ejecuta:
   ```bash
   php artisan migrate
   ```

---

## 📋 Qué Hace el Script

El script `run_migrations.php` ejecutará estas migraciones en orden:

1. ✅ `create_users_table` - Tabla de usuarios
2. ✅ `create_cache_table` - Tabla de caché
3. ✅ `create_jobs_table` - Tabla de trabajos
4. ✅ `create_categories_table` - Tabla de categorías (debe ir antes de products)
5. ✅ `create_products_table` - Tabla de productos (con foreign key a categories)

---

## 🔄 Después de Ejecutar Migraciones

Una vez que las migraciones se ejecuten correctamente:

1. **Crear usuario administrador**:
   - Ve a: `http://localhost/create_admin_user.php`
   - O regístrate desde: `http://localhost/register`

2. **Iniciar sesión**:
   - Ve a: `http://localhost/login`
   - Credenciales (si usas create_admin_user.php):
     - Email: `admin@sistema.com`
     - Contraseña: `admin123`

3. **Acceder al dashboard**:
   - Deberías poder ver: `http://localhost/admin` sin errores

---

## ⚠️ Seguridad

**IMPORTANTE**: Después de ejecutar los scripts, elimínalos por seguridad:

- `run_migrations.php`
- `create_admin_user.php`

Estos archivos no deben estar en producción.

---

## 🐛 Si Sigues Teniendo Problemas

1. Verifica que la base de datos SQLite existe:
   - Debería estar en: `database/database.sqlite`

2. Verifica permisos de escritura en la carpeta `database/`

3. Si necesitas recrear la base de datos:
   ```bash
   # Elimina la base de datos
   rm database/database.sqlite
   
   # Crea una nueva
   touch database/database.sqlite
   
   # Ejecuta migraciones de nuevo
   php artisan migrate
   ```

