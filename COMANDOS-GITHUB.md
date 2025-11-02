# 📤 Comandos para Subir el Proyecto a GitHub

## 🔧 Pre-requisitos

1. **Asegúrate de que Git esté instalado** (viene con Laragon)
2. **Configura Git** (si aún no lo has hecho):

```bash
git config --global user.name "Tu Nombre"
git config --global user.email "tu-email@ejemplo.com"
```

## 📋 Pasos para Subir el Proyecto

### Opción 1: Desde Git Bash de Laragon

1. Abre **Laragon** → Click derecho en `callcenter` → **Terminal Here (Git Bash)**

2. Ejecuta estos comandos:

```bash
# 1. Inicializar Git (si no está inicializado)
git init

# 2. Agregar todos los archivos
git add .

# 3. Hacer el primer commit
git commit -m "Initial commit: Sistema CallCenter con gestión de cursos, clientes y operadores"

# 4. Agregar el repositorio remoto
git remote add origin https://github.com/rodolfojha/cursospanel.git

# 5. Verificar el remote
git remote -v

# 6. Subir al repositorio (branch main)
git branch -M main
git push -u origin main
```

### Opción 2: Desde PowerShell (si Git está en el PATH)

Abre PowerShell en la carpeta del proyecto y ejecuta los mismos comandos.

### Opción 3: Usando el PATH completo de Git en Laragon

Si Git no está en el PATH, usa la ruta completa:

```powershell
# Verificar la ruta de Git en Laragon (puede variar)
C:\laragon\bin\git\bin\git.exe --version

# Luego usar la ruta completa para los comandos
C:\laragon\bin\git\bin\git.exe init
C:\laragon\bin\git\bin\git.exe add .
C:\laragon\bin\git\bin\git.exe commit -m "Initial commit"
C:\laragon\bin\git\bin\git.exe remote add origin https://github.com/rodolfojha/cursospanel.git
C:\laragon\bin\git\bin\git.exe branch -M main
C:\laragon\bin\git\bin\git.exe push -u origin main
```

## 🔐 Si te pide credenciales

Si GitHub te pide usuario y contraseña:

1. **Usuario:** `rodolfojha`
2. **Contraseña:** Usa un **Personal Access Token** (no tu contraseña normal)

### Crear Personal Access Token:

1. Ve a GitHub.com → Settings → Developer settings → Personal access tokens → Tokens (classic)
2. Generate new token (classic)
3. Selecciona los permisos: `repo` (todos)
4. Copia el token generado
5. Úsalo como contraseña cuando Git te lo pida

## 📝 Archivos que NO se subirán (por .gitignore)

✅ `.env` - Configuración local (crea un `.env.example`)
✅ `vendor/` - Dependencias de Composer
✅ `node_modules/` - Dependencias de npm
✅ `storage/app/public/*` - Archivos subidos (excepto estructura)
✅ `database/database.sqlite` - Base de datos SQLite local

## 🔄 Actualizaciones Futuras

Para subir cambios después:

```bash
git add .
git commit -m "Descripción de los cambios"
git push
```

## ⚠️ Importante

Antes de subir, asegúrate de:

1. ✅ No tener datos sensibles en el código
2. ✅ El archivo `.env` está en `.gitignore`
3. ✅ Crear un archivo `.env.example` con estructura pero sin datos reales
4. ✅ Revisar que no haya archivos temporales o de prueba

## 🆘 Solución de Problemas

### Error: "remote origin already exists"
```bash
git remote remove origin
git remote add origin https://github.com/rodolfojha/cursospanel.git
```

### Error: "failed to push some refs"
```bash
git pull origin main --allow-unrelated-histories
git push -u origin main
```

### Ver qué se va a subir antes del push
```bash
git status
git log --oneline
```

