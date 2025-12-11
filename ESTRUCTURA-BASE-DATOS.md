
1. [Resumen General](#resumen-general)
2. [Diagrama de Relaciones](#diagrama-de-relaciones)
3. [Tablas del Sistema](#tablas-del-sistema)
   - [users](#users)
   - [clients](#clients)
   - [courses](#courses)
   - [course_materials](#course_materials)
   - [cache](#cache)
   - [cache_locks](#cache_locks)
   - [jobs](#jobs)
   - [job_batches](#job_batches)
   - [failed_jobs](#failed_jobs)
   - [sessions](#sessions)
   - [password_reset_tokens](#password_reset_tokens)
   - [migrations](#migrations)

---

## Resumen General

**Base de Datos:** `callcenter`  
**Motor:** MariaDB 10.11.13 / MySQL 5.7+  
**Total de Tablas:** 12  
**Charset:** utf8mb4  
**Collation:** utf8mb4_unicode_ci

### Tablas Principales del Sistema
- **users**: Usuarios del sistema (administradores y operadores)
- **clients**: Clientes del call center
- **courses**: Cursos de capacitación
- **course_materials**: Materiales multimedia de los cursos

### Tablas del Framework Laravel
- **cache** / **cache_locks**: Sistema de caché
- **jobs** / **job_batches** / **failed_jobs**: Sistema de colas
- **sessions**: Sesiones de usuarios
- **password_reset_tokens**: Tokens para recuperación de contraseña
- **migrations**: Control de versiones de base de datos

---

## Diagrama de Relaciones

```
┌─────────────────┐
│     users        │
│─────────────────│
│ id (PK)         │
│ name            │◄─────┐
│ email           │       │
│ password        │       │
│ role            │       │
│ created_at      │       │
│ updated_at      │       │
└─────────────────┘       │
                          │
┌─────────────────┐       │
│    clients       │       │
│─────────────────│       │
│ id (PK)         │       │
│ first_name      │       │
│ last_name       │       │
│ phone           │       │
│ email           │       │
│ address         │       │
│ city            │       │
│ state           │       │
│ notes           │       │
│ assigned_to(FK) │───────┘
│ assigned_at     │
│ status          │
│ created_at      │
│ updated_at      │
└─────────────────┘

┌─────────────────┐
│    courses       │
│─────────────────│
│ id (PK)         │◄─────┐
│ title           │       │
│ description     │       │
│ thumbnail       │       │
│ status          │       │
│ duration_minutes│       │
│ created_by (FK) │───────┘
│ created_at      │
│ updated_at      │
└─────────────────┘
        │
        │ 1:N
        ▼
┌──────────────────────┐
│ course_materials     │
│──────────────────────│
│ id (PK)              │
│ course_id (FK)       │
│ title                │
│ description          │
│ type                 │
│ file_path            │
│ file_name            │
│ file_size            │
│ mime_type            │
│ order                │
│ created_at           │
│ updated_at           │
└──────────────────────┘
```

---

## Tablas del Sistema

### users

**Descripción:** Almacena los usuarios del sistema. Pueden ser administradores o operadores.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único del usuario | PRIMARY KEY, AUTO_INCREMENT |
| `name` | VARCHAR(255) | Nombre completo del usuario | NOT NULL |
| `email` | VARCHAR(255) | Correo electrónico | NOT NULL, UNIQUE |
| `role` | ENUM | Rol del usuario | NOT NULL, DEFAULT 'operator', Valores: 'admin', 'operator' |
| `email_verified_at` | TIMESTAMP | Fecha de verificación del email | NULLABLE |
| `password` | VARCHAR(255) | Contraseña hasheada | NOT NULL |
| `remember_token` | VARCHAR(100) | Token para "recordar sesión" | NULLABLE |
| `created_at` | TIMESTAMP | Fecha de creación | NULLABLE |
| `updated_at` | TIMESTAMP | Fecha de última actualización | NULLABLE |

#### Índices
- PRIMARY KEY: `id`
- UNIQUE: `email`

#### Relaciones
- **hasMany**: `clients` (a través de `assigned_to`)
- **hasMany**: `courses` (a través de `created_by`)

#### Valores de `role`
- **`admin`**: Administrador del sistema (acceso completo)
- **`operator`**: Operador del call center (acceso limitado)

---

### clients

**Descripción:** Almacena la información de los clientes del call center y su estado de asignación a operadores.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único del cliente | PRIMARY KEY, AUTO_INCREMENT |
| `first_name` | VARCHAR(255) | Nombre del cliente | NOT NULL |
| `last_name` | VARCHAR(255) | Apellido del cliente | NOT NULL |
| `phone` | VARCHAR(255) | Teléfono del cliente | NOT NULL |
| `email` | VARCHAR(255) | Correo electrónico | NULLABLE |
| `address` | TEXT | Dirección completa | NULLABLE |
| `city` | VARCHAR(255) | Ciudad | NULLABLE |
| `state` | VARCHAR(255) | Estado/Provincia | NULLABLE |
| `notes` | TEXT | Notas adicionales del cliente | NULLABLE |
| `assigned_to` | BIGINT UNSIGNED | ID del operador asignado | FOREIGN KEY, NULLABLE |
| `assigned_at` | TIMESTAMP | Fecha y hora de asignación | NULLABLE |
| `status` | ENUM | Estado del cliente | NOT NULL, DEFAULT 'waiting', Valores: 'waiting', 'assigned', 'contacted', 'completed' |
| `created_at` | TIMESTAMP | Fecha de creación | NULLABLE |
| `updated_at` | TIMESTAMP | Fecha de última actualización | NULLABLE |

#### Índices
- PRIMARY KEY: `id`
- FOREIGN KEY: `assigned_to` → `users.id` (ON DELETE SET NULL)

#### Relaciones
- **belongsTo**: `users` (a través de `assigned_to` - relación `assignedTo()`)

#### Estados de `status`
- **`waiting`**: Cliente en espera de asignación
- **`assigned`**: Cliente asignado a un operador
- **`contacted`**: Cliente ya contactado por el operador
- **`completed`**: Cliente atendido completamente

#### Métodos del Modelo
- `getFullNameAttribute()`: Retorna nombre completo (first_name + last_name)
- `isAvailable()`: Verifica si el cliente está disponible para asignación
- `assignTo(User $user)`: Asigna el cliente a un operador
- `scopeAvailable($query)`: Scope para clientes disponibles
- `scopeAssignedTo($query, $userId)`: Scope para clientes de un operador

---

### courses

**Descripción:** Almacena la información de los cursos de capacitación disponibles en el sistema.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único del curso | PRIMARY KEY, AUTO_INCREMENT |
| `title` | VARCHAR(255) | Título del curso | NOT NULL |
| `description` | TEXT | Descripción detallada del curso | NULLABLE |
| `thumbnail` | VARCHAR(255) | Ruta de la imagen de portada | NULLABLE |
| `status` | ENUM | Estado del curso | NOT NULL, DEFAULT 'draft', Valores: 'draft', 'published', 'archived' |
| `duration_minutes` | INT | Duración estimada en minutos | NULLABLE |
| `created_by` | BIGINT UNSIGNED | ID del usuario que creó el curso | FOREIGN KEY, NOT NULL |
| `created_at` | TIMESTAMP | Fecha de creación | NULLABLE |
| `updated_at` | TIMESTAMP | Fecha de última actualización | NULLABLE |

#### Índices
- PRIMARY KEY: `id`
- FOREIGN KEY: `created_by` → `users.id` (ON DELETE CASCADE)

#### Relaciones
- **belongsTo**: `users` (a través de `created_by` - relación `creator()`)
- **hasMany**: `course_materials` (relación `materials()`)

#### Relaciones Especiales del Modelo
- `videos()`: Materiales de tipo 'video'
- `pdfs()`: Materiales de tipo 'pdf'
- `images()`: Materiales de tipo 'image'

#### Estados de `status`
- **`draft`**: Borrador (no publicado)
- **`published`**: Publicado y disponible
- **`archived`**: Archivado (no visible)

#### Métodos del Modelo
- `getStatusLabelAttribute()`: Retorna etiqueta del estado en español
- `getStatusColorAttribute()`: Retorna color para el estado

---

### course_materials

**Descripción:** Almacena los materiales multimedia asociados a cada curso (videos, PDFs, imágenes, documentos).

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único del material | PRIMARY KEY, AUTO_INCREMENT |
| `course_id` | BIGINT UNSIGNED | ID del curso al que pertenece | FOREIGN KEY, NOT NULL |
| `title` | VARCHAR(255) | Título del material | NOT NULL |
| `description` | TEXT | Descripción del material | NULLABLE |
| `type` | ENUM | Tipo de material | NOT NULL, Valores: 'video', 'pdf', 'image', 'document' |
| `file_path` | VARCHAR(255) | Ruta completa del archivo en el servidor | NOT NULL |
| `file_name` | VARCHAR(255) | Nombre original del archivo | NOT NULL |
| `file_size` | VARCHAR(255) | Tamaño del archivo | NULLABLE |
| `mime_type` | VARCHAR(255) | Tipo MIME del archivo | NULLABLE |
| `order` | INT | Orden de visualización | NOT NULL, DEFAULT 0 |
| `created_at` | TIMESTAMP | Fecha de creación | NULLABLE |
| `updated_at` | TIMESTAMP | Fecha de última actualización | NULLABLE |

#### Índices
- PRIMARY KEY: `id`
- FOREIGN KEY: `course_id` → `courses.id` (ON DELETE CASCADE)

#### Relaciones
- **belongsTo**: `courses` (relación `course()`)

#### Tipos de Material (`type`)
- **`video`**: Archivo de video
- **`pdf`**: Documento PDF
- **`image`**: Imagen
- **`document`**: Documento (Word, Excel, etc.)

#### Métodos del Modelo
- `getTypeLabelAttribute()`: Retorna etiqueta del tipo en español
- `getTypeIconAttribute()`: Retorna icono FontAwesome para el tipo
- `getTypeColorAttribute()`: Retorna color para el tipo
- `getFormattedSizeAttribute()`: Formatea el tamaño del archivo (KB, MB, GB)

**Nota:** Los materiales se ordenan automáticamente por el campo `order` al obtenerlos a través de la relación `materials()`.

---

## Tablas del Framework Laravel

### cache

**Descripción:** Tabla utilizada por Laravel para almacenar datos en caché cuando se usa el driver 'database'.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `key` | VARCHAR(255) | Clave única del cache | PRIMARY KEY |
| `value` | MEDIUMTEXT | Valor almacenado en caché | NOT NULL |
| `expiration` | INT | Timestamp de expiración | NOT NULL |

#### Índices
- PRIMARY KEY: `key`

---

### cache_locks

**Descripción:** Tabla para gestionar bloqueos distribuidos en el sistema de caché.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `key` | VARCHAR(255) | Clave única del lock | PRIMARY KEY |
| `owner` | VARCHAR(255) | Identificador del propietario del lock | NOT NULL |
| `expiration` | INT | Timestamp de expiración del lock | NOT NULL |

#### Índices
- PRIMARY KEY: `key`

---

### jobs

**Descripción:** Tabla para almacenar trabajos en cola pendientes de ejecución.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único | PRIMARY KEY, AUTO_INCREMENT |
| `queue` | VARCHAR(255) | Nombre de la cola | NOT NULL, INDEX |
| `payload` | LONGTEXT | Datos serializados del trabajo | NOT NULL |
| `attempts` | TINYINT UNSIGNED | Número de intentos realizados | NOT NULL |
| `reserved_at` | INT UNSIGNED | Timestamp de reserva | NULLABLE |
| `available_at` | INT UNSIGNED | Timestamp de disponibilidad | NOT NULL |
| `created_at` | INT UNSIGNED | Timestamp de creación | NOT NULL |

#### Índices
- PRIMARY KEY: `id`
- INDEX: `queue`

---

### job_batches

**Descripción:** Tabla para gestionar lotes de trabajos en cola.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | VARCHAR(255) | Identificador único del lote | PRIMARY KEY |
| `name` | VARCHAR(255) | Nombre del lote | NOT NULL |
| `total_jobs` | INT | Total de trabajos en el lote | NOT NULL |
| `pending_jobs` | INT | Trabajos pendientes | NOT NULL |
| `failed_jobs` | INT | Trabajos fallidos | NOT NULL |
| `failed_job_ids` | LONGTEXT | IDs de trabajos fallidos | NOT NULL |
| `options` | MEDIUMTEXT | Opciones del lote | NULLABLE |
| `cancelled_at` | INT | Timestamp de cancelación | NULLABLE |
| `created_at` | INT | Timestamp de creación | NOT NULL |
| `finished_at` | INT | Timestamp de finalización | NULLABLE |

#### Índices
- PRIMARY KEY: `id`

---

### failed_jobs

**Descripción:** Tabla para almacenar trabajos que han fallado en la ejecución.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único | PRIMARY KEY, AUTO_INCREMENT |
| `uuid` | VARCHAR(255) | UUID único del trabajo | NOT NULL, UNIQUE |
| `connection` | TEXT | Nombre de la conexión | NOT NULL |
| `queue` | TEXT | Nombre de la cola | NOT NULL |
| `payload` | LONGTEXT | Datos del trabajo fallido | NOT NULL |
| `exception` | LONGTEXT | Mensaje de excepción | NOT NULL |
| `failed_at` | TIMESTAMP | Fecha del fallo | NOT NULL, DEFAULT CURRENT_TIMESTAMP |

#### Índices
- PRIMARY KEY: `id`
- UNIQUE: `uuid`

---

### sessions

**Descripción:** Tabla para almacenar las sesiones de usuario cuando se usa el driver 'database'.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | VARCHAR(255) | ID único de la sesión | PRIMARY KEY |
| `user_id` | BIGINT UNSIGNED | ID del usuario (si está autenticado) | FOREIGN KEY, NULLABLE, INDEX |
| `ip_address` | VARCHAR(45) | Dirección IP del cliente | NULLABLE |
| `user_agent` | TEXT | User agent del navegador | NULLABLE |
| `payload` | LONGTEXT | Datos de la sesión serializados | NOT NULL |
| `last_activity` | INT | Timestamp de última actividad | NOT NULL, INDEX |

#### Índices
- PRIMARY KEY: `id`
- INDEX: `user_id`
- INDEX: `last_activity`
- FOREIGN KEY: `user_id` → `users.id` (ON DELETE SET NULL)

---

### password_reset_tokens

**Descripción:** Tabla para almacenar tokens de recuperación de contraseña.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `email` | VARCHAR(255) | Correo electrónico | PRIMARY KEY |
| `token` | VARCHAR(255) | Token de recuperación | NOT NULL |
| `created_at` | TIMESTAMP | Fecha de creación del token | NULLABLE |

#### Índices
- PRIMARY KEY: `email`

---

### migrations

**Descripción:** Tabla de control de Laravel que registra las migraciones ejecutadas.

#### Campos

| Campo | Tipo | Descripción | Restricciones |
|-------|------|-------------|---------------|
| `id` | BIGINT UNSIGNED | Identificador único | PRIMARY KEY, AUTO_INCREMENT |
| `migration` | VARCHAR(255) | Nombre de la migración | NOT NULL |
| `batch` | INT | Número de lote de ejecución | NOT NULL |

#### Índices
- PRIMARY KEY: `id`

---

## 📝 Notas Importantes

### Políticas de Eliminación (ON DELETE)

1. **CASCADE**: Cuando se elimina un registro padre, se eliminan automáticamente los registros hijos.
   - `courses.created_by` → Si se elimina un usuario, se eliminan sus cursos
   - `course_materials.course_id` → Si se elimina un curso, se eliminan sus materiales

2. **SET NULL**: Cuando se elimina un registro padre, los registros hijos mantienen la referencia pero en NULL.
   - `clients.assigned_to` → Si se elimina un operador, los clientes asignados quedan sin asignación
   - `sessions.user_id` → Si se elimina un usuario, las sesiones mantienen el user_id como NULL

### Convenciones de Nombres

- **Timestamps**: Todas las tablas principales incluyen `created_at` y `updated_at` (excepto tablas del sistema de Laravel)
- **Foreign Keys**: Siguen el patrón `{tabla}_id` (ej: `course_id`, `user_id`, `assigned_to`)
- **Enums**: Los campos enum tienen valores descriptivos y en inglés (excepto estados de UI que pueden estar en español)

### Almacenamiento de Archivos

- **Cursos**: Las imágenes de portada se almacenan en `storage/app/public/courses/thumbnails/`
- **Materiales**: Los archivos se almacenan en `storage/app/public/courses/materials/`
- Las rutas se guardan en la base de datos, no los archivos binarios

### Consultas Útiles

```sql
-- Ver todos los clientes asignados a un operador
SELECT * FROM clients WHERE assigned_to = 1;

-- Ver todos los materiales de un curso ordenados
SELECT * FROM course_materials WHERE course_id = 1 ORDER BY `order` ASC;

-- Ver cursos publicados con sus materiales
SELECT c.*, COUNT(cm.id) as materials_count 
FROM courses c 
LEFT JOIN course_materials cm ON c.id = cm.course_id 
WHERE c.status = 'published' 
GROUP BY c.id;

-- Ver clientes en espera de asignación
SELECT * FROM clients WHERE status = 'waiting' AND assigned_to IS NULL;
```

---

## 🔄 Flujo de Trabajo del Sistema

1. **Clientes** se crean con estado `waiting`
2. Los **Operadores** (users con role='operator') pueden tomar clientes disponibles
3. Al asignar, el cliente cambia a `assigned` y se registra `assigned_at`
4. Los **Cursos** pueden ser creados por cualquier usuario
5. Cada curso puede tener múltiples **Materiales** de diferentes tipos
6. Los materiales se ordenan por el campo `order` para su visualización

---

**Última actualización:** Noviembre 2025  
**Versión del Sistema:** Laravel 12.36.1  
**Motor de Base de Datos:** MariaDB 10.11.13
