# Ver el Diseño Funcionando

## Pasos para visualizar:

### 1. Iniciar el servidor de Laravel

Abre la terminal de Laragon y ejecuta:
```bash
cd C:\laragon\www\callcenter
php artisan serve
```

### 2. Crear un usuario de prueba

Abre **otra terminal** y ejecuta:
```bash
cd C:\laragon\www\callcenter
php artisan tinker
```

Luego dentro de tinker, crea un usuario:
```php
\App\Models\User::create([
    'name' => 'Admin CallCenter',
    'email' => 'admin@callcenter.com',
    'password' => bcrypt('password')
]);
```

Presiona `Ctrl+C` para salir de tinker.

### 3. Crear middleware de autenticación temporal

Para ver el dashboard sin sistema de login completo, ejecuta:
```bash
php artisan make:middleware AutoLogin
```

Esto permitirá acceder al dashboard automáticamente.

### 4. Acceder al dashboard

Abre tu navegador y ve a:
```
http://localhost:8000/dashboard
```

O si Laragon usa otro puerto:
```
http://callcenter.test/dashboard
```

---

## Método alternativo (más rápido)

Si prefieres ver el diseño inmediatamente sin autenticación, ejecuta:

```bash
php artisan make:middleware AutoLogin
```

Y sigue las instrucciones que te daré para configurarlo.

