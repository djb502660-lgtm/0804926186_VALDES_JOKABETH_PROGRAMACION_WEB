# 🔐 Credenciales de Acceso al Sistema

## Usuario Administrador (Por Defecto)

Después de ejecutar el seeder, puedes usar estas credenciales:

```
Email: admin@sistema.com
Contraseña: admin123
```

---

## 📝 Opciones para Crear/Usar Usuario

### Opción 1: Usar el Registro (Recomendado)
1. Ve a la página de inicio
2. Haz clic en "Registrarse"
3. Completa el formulario:
   - Nombre completo
   - Correo electrónico
   - Contraseña
   - Confirmar contraseña
4. Serás redirigido automáticamente al dashboard después del registro

### Opción 2: Ejecutar el Seeder
Si quieres crear el usuario administrador por defecto:

```bash
php artisan db:seed
```

Esto creará el usuario:
- **Email**: admin@sistema.com
- **Contraseña**: admin123

### Opción 3: Crear Usuario Manualmente (Tinker)
Si prefieres crear un usuario personalizado:

```bash
php artisan tinker
```

Luego ejecuta:
```php
App\Models\User::create([
    'name' => 'Tu Nombre',
    'email' => 'tu@email.com',
    'password' => Hash::make('tu_contraseña'),
    'email_verified_at' => now(),
]);
```

---

## 🔒 Seguridad Importante

⚠️ **IMPORTANTE**: Cambia la contraseña por defecto después del primer acceso.

1. Inicia sesión con las credenciales por defecto
2. Ve a tu perfil (si está implementado) o cambia la contraseña directamente en la base de datos
3. Para cambiar desde Tinker:
   ```php
   $user = App\Models\User::where('email', 'admin@sistema.com')->first();
   $user->password = Hash::make('nueva_contraseña_segura');
   $user->save();
   ```

---

## 📋 Usuarios Creados

### Usuario Administrador (Seeder)
- **Email**: admin@sistema.com
- **Contraseña**: admin123
- **Tipo**: Administrador completo

### Usuario de Prueba (Factory - si se ejecuta)
- **Email**: test@example.com
- **Contraseña**: password
- **Nota**: Este usuario solo se crea si ejecutas el factory sin modificarlo

---

## 🚀 Primeros Pasos

1. **Ejecuta las migraciones** (si aún no lo has hecho):
   ```bash
   php artisan migrate
   ```

2. **Ejecuta el seeder** para crear el usuario administrador:
   ```bash
   php artisan db:seed
   ```

3. **Accede al sistema**:
   - Ve a: `http://localhost` (o tu dominio)
   - Haz clic en "Iniciar Sesión"
   - Ingresa las credenciales:
     - Email: `admin@sistema.com`
     - Contraseña: `admin123`

4. **Explora el dashboard** y gestiona productos, categorías y usuarios.

---

## 📝 Notas

- Todos los usuarios tienen acceso completo al sistema (no hay roles diferenciados por ahora)
- Puedes crear múltiples usuarios usando el registro
- Las contraseñas se almacenan con hash seguro (bcrypt)
- El sistema tiene protección CSRF en todos los formularios

---

**Fecha de Creación**: Diciembre 2024  
**Sistema**: Sistema de Gestión Laravel
