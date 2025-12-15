# Configuración de Selenium + NopeCHA

## Requisitos instalados
- ✅ Google Chrome
- ✅ Python 3 con Selenium
- ✅ WebDriver Manager

## Instalar extensión NopeCHA

### Opción 1: Descargar la extensión manualmente

1. Ve a https://nopecha.com/
2. Descarga la extensión para Chrome (archivo .crx o carpeta descomprimida)
3. Copia la carpeta de la extensión a:
   ```
   /var/www/elecciones/storage/app/scripts/nopecha/
   ```

### Opción 2: Usar la API de NopeCHA (Recomendado)

1. Regístrate en https://nopecha.com/ y obtén tu API Key
2. Edita el script `consultar_cedula.py` y agrega tu API Key

### Opción 3: Descargar desde Chrome Web Store

```bash
# Crear directorio
mkdir -p /var/www/elecciones/storage/app/scripts/nopecha

# La extensión se puede descargar usando herramientas como crx-download
# O extraerla manualmente del navegador Chrome
```

## Probar el script

```bash
cd /var/www/elecciones/storage/app/scripts
source venv/bin/activate
python consultar_cedula.py 12345678
```

## Notas importantes

1. **Modo Headless**: El script corre en modo headless (sin interfaz gráfica) por defecto.
   Si necesitas ver el navegador para debug, edita el script y comenta la línea:
   ```python
   chrome_options.add_argument("--headless=new")
   ```

2. **Captchas**: La página de la Registraduría puede tener captchas que NopeCHA resolverá automáticamente si está configurado correctamente.

3. **Timeouts**: El script espera hasta 90 segundos para completar la consulta.

## Estructura de archivos

```
/var/www/elecciones/storage/app/scripts/
├── consultar_cedula.py  # Script principal
├── venv/                # Entorno virtual de Python
├── nopecha/             # Extensión NopeCHA (opcional)
└── README.md            # Este archivo
```



