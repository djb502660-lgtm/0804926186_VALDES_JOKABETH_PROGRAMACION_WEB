# 🔧 Crear Usuario Administrador

## Opción 1: Desde el Navegador (MÁS FÁCIL)

1. Asegúrate de que tu servidor esté corriendo (Laragon)
2. Abre tu navegador y ve a:
   ```
   http://localhost/create_admin_user.php
   ```
3. Deberías ver un mensaje de éxito
4. **IMPORTANTE**: Elimina el archivo `create_admin_user.php` después de usarlo por seguridad

---

## Opción 2: Desde la Terminal (si tienes PHP 8.2+)

Si tu terminal tiene PHP 8.2 o superior configurado:

```bash
php create_admin_user.php
```

---

## Opción 3: Ejecutar Seeder (si funciona tu PHP)

Si puedes ejecutar artisan:

```bash
php artisan db:seed
```

---

## Opción 4: Crear Usuario desde la Base de Datos Directamente

Si ninguna opción anterior funciona, puedes insertar el usuario directamente en la base de datos:

### Para SQLite (database.sqlite):

```sql
INSERT OR REPLACE INTO users (id, name, email, password, email_verified_at, created_at, updated_at)
VALUES (
    1,
    'Administrador',
    'admin@sistema.com',
    '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', -- password: admin123
    datetime('now'),
    datetime('now'),
    datetime('now')
);
```

**Nota**: El hash de contraseña mostrado es para 'admin123'. Puedes generar uno nuevo usando:
```php
echo Hash::make('tu_contraseña');
```

---

## Credenciales Creadas

Después de ejecutar cualquiera de las opciones:

```
📧 Email: admin@sistema.com
🔑 Contraseña: admin123
```

---

## Seguridad

⚠️ **IMPORTANTE**: 
- Cambia la contraseña después del primer acceso
- Elimina el archivo `create_admin_user.php` después de usarlo
- No dejes credenciales por defecto en producción

---

## Verificar que Funcionó

1. Ve a: http://localhost/login
2. Ingresa las credenciales:
   - Email: `admin@sistema.com`
   - Contraseña: `admin123`
3. Deberías ser redirigido al dashboard

