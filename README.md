# 📞 Sistema CallCenter

Sistema de gestión de call center desarrollado con Laravel, que incluye gestión de clientes, operadores, cursos y monitoreo en tiempo real.

## 🚀 Características

- ✅ **Gestión de Clientes**: Asignación en tiempo real a operadores
- ✅ **Gestión de Operadores**: Administración de cuentas de operadores
- ✅ **Gestión de Cursos**: Sistema completo con materiales (videos, PDFs, imágenes)
- ✅ **Monitoreo en Tiempo Real**: Visualización de qué operador atiende qué cliente
- ✅ **Historial de Clientes**: Ver clientes completados con notas del operador
- ✅ **Roles y Permisos**: Administrador y Operador
- ✅ **Interfaz Moderna**: Diseño con Tailwind CSS v4 y Livewire Flux

## 📋 Requisitos

- PHP >= 8.1
- MySQL >= 5.7 o MariaDB >= 10.3
- Composer
- Node.js >= 18
- npm

## 🔧 Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/rodolfojha/cursospanel.git
cd cursospanel
```

2. **Instalar dependencias**
```bash
composer install
npm install
```

3. **Configurar el entorno**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos en `.env`**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=callcenter
DB_USERNAME=root
DB_PASSWORD=tu_password
```

5. **Ejecutar migraciones y seeders**
```bash
php artisan migrate --seed
php artisan storage:link
```

6. **Compilar assets**
```bash
npm run build
```

7. **Iniciar el servidor**
```bash
php artisan serve
```

## 👤 Usuarios de Prueba

Después de ejecutar los seeders, puedes iniciar sesión con:

- **Administrador:**
  - Email: `admin@callcenter.com`
  - Password: `admin123`

- **Operador:**
  - Email: `operador@callcenter.com`
  - Password: `operador123`

## 📁 Estructura del Proyecto

```
callcenter/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Livewire/             # Componentes Livewire
│   ├── Models/                # Modelos Eloquent
│   └── ...
├── database/
│   ├── migrations/            # Migraciones
│   └── seeders/              # Seeders
├── resources/
│   ├── views/                 # Vistas Blade
│   ├── css/                   # Estilos CSS
│   └── js/                    # JavaScript
└── storage/
    └── app/public/            # Archivos públicos (cursos, imágenes)
```

## 🗄️ Base de Datos

El sistema utiliza MySQL con las siguientes tablas principales:

- `users` - Usuarios (administradores y operadores)
- `clients` - Clientes del call center
- `courses` - Cursos de capacitación
- `course_materials` - Materiales de los cursos (videos, PDFs, imágenes)

## 🔐 Archivos Importantes

- `.env` - Configuración del entorno (NO se sube a GitHub)
- `.env.example` - Ejemplo de configuración
- `COMANDOS-GITHUB.md` - Instrucciones para subir el proyecto

## 📝 Notas

- Los archivos de cursos se guardan en `storage/app/public/courses/`
- Las rutas de archivos se almacenan en la BD, no los archivos binarios
- El sistema usa Livewire para actualizaciones en tiempo real

## 👨‍💻 Desarrollado con

- Laravel 12
- Livewire
- Tailwind CSS v4
- Livewire Flux
- MySQL

## 📄 Licencia

Este proyecto es privado y de uso exclusivo.
