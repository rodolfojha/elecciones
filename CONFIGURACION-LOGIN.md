# Sistema de Login con Roles - CallCenter

## ✅ ¡Sistema de autenticación instalado y configurado! 🔐

### ✅ Migraciones y seeders ejecutados

Los usuarios de prueba ya están creados y listos para usar.

## Usuarios de Prueba

### Administrador
- **Email:** admin@callcenter.com
- **Password:** admin123
- **Rol:** admin

### Operadores
- **Email:** operador@callcenter.com
- **Password:** operador123
- **Rol:** operator

- **Email:** juan@callcenter.com
- **Password:** operador123
- **Rol:** operator

## Cómo usar el sistema

### 1. Iniciar sesión
Ve a: `http://127.0.0.1:8000/login`

### 2. Roles implementados

**Administrador:**
- Acceso completo al sistema
- Puede gestionar usuarios
- Acceso a todas las funcionalidades

**Operador:**
- Acceso limitado
- Solo funcionalidades de operación
- Sin permisos administrativos

### 3. Proteger rutas por rol

En `routes/web.php` ya están configuradas las rutas protegidas:

**Solo administradores:**
```php
Route::middleware(['auth', App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::resource('users', UserController::class);
    // Más rutas admin
});
```

**Administradores y operadores:**
```php
Route::middleware(['auth', App\Http\Middleware\CheckRole::class . ':admin,operator'])->group(function () {
    Route::resource('clientes', ClienteController::class);
    // Más rutas compartidas
});
```

### 4. Verificar rol en vistas

```blade
@if(auth()->user()->isAdmin())
    <!-- Contenido solo para admin -->
@endif

@if(auth()->user()->isOperator())
    <!-- Contenido solo para operadores -->
@endif
```

### 5. Verificar rol en controladores

```php
if (auth()->user()->isAdmin()) {
    // Lógica para admin
}

if (auth()->user()->isOperator()) {
    // Lógica para operador
}
```

## Características implementadas

✅ Login con diseño de natplayer
✅ Sistema de roles (admin y operator)
✅ Middleware para proteger rutas por rol
✅ Métodos helper en modelo User (`isAdmin()`, `isOperator()`)
✅ Seeders con usuarios de prueba
✅ Logout funcional
✅ Protección de rutas con middleware `auth`

## Próximos pasos

1. Crear controladores para gestión de usuarios (admin)
2. Crear vistas específicas para cada rol
3. Agregar más funcionalidades según necesidad

¡El sistema de autenticación está listo! 🚀

